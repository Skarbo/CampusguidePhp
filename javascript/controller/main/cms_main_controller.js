// CONSTRUCTOR
CmsMainController.prototype = new MainController();

function CmsMainController(eventHandler, mode, query) {
	MainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {CmsMainView}
 */
CmsMainController.prototype.getView = function() {
	return MainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

CmsMainController.prototype.doBindEventHandler = function() {
	MainController.prototype.doBindEventHandler.call(this);
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
CmsMainController.prototype.handleQueue = function(queueType, queue) {

	var context = this;

	// Queue type building
	if (queueType == "building") {

		// Building id must be given
		if (!queue.buildingId) {
			console.error("Queue building id is not given");
			return;
		}

		// Building retrieve event
		context.getEventHandler().handle(new RetrieveEvent("building_queue", queue.buildingId));

		// Retrieve Building
		this.getDaoContainer().getBuildingDao().get(queue.buildingId, function(building) {
			context.getEventHandler().handle(new RetrievedEvent("building_queue", building));

			// Retrieve Floors
			context.getEventHandler().handle(new RetrieveEvent("building_floors_queue", building.id));
			context.getDaoContainer().getFloorBuildingDao().getForeign(building.id, function(floors) {
				context.getEventHandler().handle(new RetrievedEvent("building_floors_queue", floors));

				// Retrieve Elements
				context.getEventHandler().handle(new RetrieveEvent("building_elements_queue", building.id));
				context.getDaoContainer().getElementBuildingDao().getBuilding(building.id, function(element, elements) {
					context.getEventHandler().handle(new RetrievedEvent("building_elements_queue", elements));
				});
			});
		});

	}

};

CmsMainController.prototype.handleBuildingCommand = function(buildingId, queueId, imageData) {

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
 * @param {CmsMainView}
 *            view
 */
CmsMainController.prototype.render = function(view) {
	MainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
