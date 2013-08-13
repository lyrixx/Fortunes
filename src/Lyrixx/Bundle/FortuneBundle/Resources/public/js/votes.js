var fortune = fortune || {};

fortune.votes = (function klass() {
    var labelKlassRegex = /label-\w+/;
    var updateClass = function($votesLabel, votes) {
        $votesLabel.removeClass(function(i, klass) {
            return labelKlassRegex.exec(klass).join(' ');
        });
        var klass = 'label-';
        if (0 === votes) {
            klass += 'warning';
        } else if (0 < votes) {
            klass += 'success';
        } else {
            klass += 'danger';
        }
        $votesLabel.addClass(klass);
    };

    return {
        updateClass: updateClass
    };
})();

