QueueEvent.prototype = new Event();

function QueueEvent(queueType, queue) {
	this.queueType = queueType;
	this.queue = queue;
}

// VARIABLES

QueueEvent.TYPE = "QueueEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {string}
 */
QueueEvent.prototype.getQueueType = function() {
	return this.queueType;
};

/**
 * @return {Object}
 */
QueueEvent.prototype.getQueue = function() {
	return this.queue;
};

QueueEvent.prototype.getType = function() {
	return QueueEvent.TYPE;
};

// /FUNCTIONS
