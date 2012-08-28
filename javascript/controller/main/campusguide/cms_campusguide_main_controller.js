// CONSTRUCTOR
CmsCampusguideMainController.prototype = new CampusguideMainController();

function CmsCampusguideMainController(eventHandler, mode, query) {
	CampusguideMainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {CmsCampusguideMainView}
 */
CmsCampusguideMainController.prototype.getView = function() {
	return CampusguideMainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

CmsCampusguideMainController.prototype.doBindEventHandler = function() {
	CampusguideMainController.prototype.doBindEventHandler.call(this);
	var context = this;

	this.getEventHandler().registerListener(QueueEvent.TYPE,
	/**
	 * @param {QueueEvent}
	 *            event
	 */
	function(event) {
		context.handleQueue(event.getQueueType(), event.getQueue());
	});

	this.getEventHandler().registerListener(BuildingCommandEvent.TYPE,
	/**
	 * @param {BuildingCommandEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingCommand(event.getBuildingId(), event.getQueueId(), event.getImageData());
	});

};

// ... /DO

// ... HANDLE

/**
 * @param {string}
 *            queueType
 * @param {Object}
 *            queue
 */
CmsCampusguideMainController.prototype.handleQueue = function(queueType, queue) {

	var context = this;

	// Queue type building
	if (queueType == "building") {

		// Building id must be given
		if (!queue.buildingId) {
			console.error("Queue building id is not given");
			return;
		}

		// Building retrieve event
		context.getEventHandler().handle(new BuildingRetrieveEvent(queue.buildingId));

		// Retrieve Building
		this.getBuildingDao().get(queue.buildingId, function(building) {
			if (!building) {
				console.error("Retrieved building is null");
				return;
			}

			context.getEventHandler().handle(new BuildingRetrievedEvent(building));
		});

	}

};

CmsCampusguideMainController.prototype.handleBuildingCommand = function(buildingId, queueId, imageData) {

	var url = Core.sprintf("command.php?/building/saveoverview/%s/%s&mode=%s", buildingId, queueId, this.getMode());

	$.ajax({
		url : url,
		data : imageData,
		type : "POST",
		beforeSend : function(xhr) {
			xhr.setRequestHeader("Content-Type", "application/upload");
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error("Error handling building command", textStatus, errorThrown);
		}
	});

};

// ... /HANDLE

// ... RENDER

/**
 * @param {CmsCampusguideMainView}
 *            view
 */
CmsCampusguideMainController.prototype.render = function(view) {
	CampusguideMainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
