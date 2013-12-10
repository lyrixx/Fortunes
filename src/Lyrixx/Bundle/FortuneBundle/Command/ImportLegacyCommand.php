<?php

namespace Lyrixx\Bundle\FortuneBundle\Command;

use Lyrixx\Bundle\FortuneBundle\Entity\Fortune;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ImportLegacyCommand
 *
 * import legacy fortune from https://github.com/mauricesvay/php-fortunes
 */
class ImportLegacyCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('fortune:legacy:import')
            ->setDescription('Import your very old fortunes')
            ->addArgument('database', InputArgument::REQUIRED, 'Path to the db file')
            ->addOption('force', null, InputOption::VALUE_NONE, 'import to db ?')
            ->addOption('force-non-valid', null, InputOption::VALUE_NONE, 'import non-valid fortune')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $database = $input->getArgument('database');

        if (!file_exists($database)) {
            throw new \InvalidArgumentException(sprintf('Imposible to find the database "%s".', $database));
        }

        if (!is_readable($database)) {
            throw new \InvalidArgumentException(sprintf('Imposible to read the database "%s".', $database));
        }

        $rows = $this->getLegacyFortune($database);

        $em = $this->getContainer()->get('doctrine')->getManager();
        $i = $j = 0;

        $fortuneReflection = new \ReflectionClass('Lyrixx\Bundle\FortuneBundle\Entity\Fortune');
        $author = $fortuneReflection->getProperty('author');
        $author->setAccessible(true);
        $quotes = $fortuneReflection->getProperty('quotes');
        $quotes->setAccessible(true);
        $votes = $fortuneReflection->getProperty('votes');
        $votes->setAccessible(true);
        $createdAt = $fortuneReflection->getProperty('createdAt');
        $createdAt->setAccessible(true);
        foreach ($rows as $row) {
            $i++;
            $fortune = new Fortune();
            $author->setValue($fortune, utf8_encode($row['author']));
            $quotes->setValue($fortune, utf8_encode($row['fortune']));
            $votes->setValue($fortune, $row['vote']);
            $createdAt->setValue($fortune, new \DateTime($row['date']));

            if (!$this->validateLegacy($input, $output, $fortune, $row)) {
                $j++;
                continue;
            }

            if ($input->getOption('force')) {
                $em->persist($fortune);
                $em->flush();
            }
        }

        $output->write(sprintf('There are <comment>%s</comment> legacy fortunes', $i));
        if ($j) {
            $output->write(sprintf(' and <comment>%s</comment> invalid one', $j));
        }
        $output->writeln('.');
        if (!$input->getOption('force')) {
            $output->writeln('<info>Re-run this command with --force option to load data in the database.</info>');
        }
    }

    private function getLegacyFortune($database)
    {
        $conn = new \PDO('sqlite:'.$database);

        $sql = 'SELECT
                    ROWID as id,
                    author,
                    fortune,
                    date,
                    vote
                FROM
                    fortunes
                WHERE
                    online = 1
        ';

        $rows = $conn->query($sql);

        if (false === $rows) {
            $info = $conn->errorInfo();
            $message = sprintf('An error occured. Code: "%s". Message: "%s".', $conn->errorCode(), $info[2]);
            if ('HY000' == $conn->errorCode()) {
                $message .= ' Are you sure the file is a SQlite3 database?';
                $message .= ' To convert an SQlite2 database to a SQlite3 database,';
                $message .= sprintf(' you can run "sqlite %s .dump | sqlite3 %s3"', $database, $database);
            }

            throw new \RuntimeException($message);
        }

        return $rows;
    }

    private function validateLegacy(InputInterface $input, OutputInterface $output, Fortune $fortune, $row)
    {
        $violations = $this->getContainer()->get('validator')->validate($fortune);
        if (count($violations)) {
            $output->writeln(sprintf('Quote <comment>#%s</comment> is invalid', $row['id']));

            if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                foreach ($violations as $violation) {
                    $output->writeln('  '.$violation->getMessage());
                    if ('quotesValid' == $violation->getPropertyPath()) {
                        $output->writeln($fortune->getQuotes());

                    }
                }
                $output->writeln('');
            }

            if (!$input->getOption('force-non-valid')) {
                return false;
            }
        }

        return true;
    }
}
