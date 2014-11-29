var fortune = fortune || {};

fortune.storage = (function storage(){
    var storageName = 'fortunes';
    var fortunesId = JSON.parse(localStorage.getItem(storageName)) || [];

    var has = function(id) {
        if (!(id in fortunesId)) {
            return false;
        }

        return id == fortunesId[id];
    };

    var add = function(id) {
        if (has(id)) {
            return;
        }

        fortunesId[id] = id;

        localStorage.setItem(storageName, JSON.stringify(fortunesId));
    };

    return {
        has: has,
        add: add
    };
})();

