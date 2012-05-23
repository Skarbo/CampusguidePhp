function MapUtil() {
}

/**
 * @param lat1
 * @param lon1
 * @param lat2
 * @param lon2
 * @returns {Number} Distance in km
 */
MapUtil.distance = function(lat1, lon1, lat2, lon2) {
    //Radius of the earth in:  1.609344 miles,  6371 km  | 
	var R = 6371;
    //var R = 3958.7558657440545; // Radius of earth in Miles 
    var dLat = MapUtil.toRad(lat2-lat1);
    var dLon = MapUtil.toRad(lon2-lon1); 
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(MapUtil.toRad(lat1)) * Math.cos(MapUtil.toRad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2); 
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    var d = R * c;
    return d;
};

MapUtil.toRad = function(value) {
    return value * Math.PI / 180;
};