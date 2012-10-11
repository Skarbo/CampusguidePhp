// CONSTRUCTOR
QueueCmsCanvasPresenterView.prototype = new CanvasPresenterView();

function QueueCmsCanvasPresenterView(view) {
	CanvasPresenterView.apply(this, arguments);

	this.type = CanvasPresenterView.TYPE_FLOORS;
	this.retrieved = 0;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Object}
 */
QueueCmsCanvasPresenterView.prototype.getCanvasContentElement = function() {
	return this.getRoot().find("#queue");
};

// ... /GET

// ... DO

QueueCmsCanvasPresenterView.prototype.doBindEventHandler = function() {
	CanvasPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Retrieved event
	this.getView().getController().getEventHandler().registerListener(RetrievedEvent.TYPE,
	/**
	 * @param {RetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleRetrieved(event.getRetrievedType(), event.getRetrieved());
	});

	// /EVENTS

};

// ... /DO

// ... HANDLE

QueueCmsCanvasPresenterView.prototype.handleRetrieved = function(type, retrieved) {
	var context = this;

	switch (type) {
	case "building_queue":
		context.handleBuildingRetrieved(retrieved);
		this.retrieved++;
		break;

	case "building_floors_queue":
		context.handleFloorsRetrieved(retrieved);
		this.retrieved++;
		break;

	case "building_elements_queue":
		context.handleElementsRetrieved(retrieved);
		this.retrieved++;
		break;
	}

	if (this.retrieved == 3 && Core.countObject(this.getView().getFloors()) > 0) {
		// Select Floor
		var selectMainFloor = function(floors) {
			var floorMain = null;
			var i = 0;
			for (floorId in floors) {
				if (floors[floorId].main || i == 0)
					floorMain = floorId;
				i++;
			}
			return floorMain;
		};

		var selectFloor = selectMainFloor(this.getView().getFloors());
		
		this.doFloorSelect(selectFloor, [QueueCmsCanvasPresenterView.TYPE_FLOORS]);

		// Fit to scale
		this.doFitToScale();

		// Send image data
		this.stage.toDataURL({
			callback : function(dataUrl) {
				context.getEventHandler().handle(new BuildingCommandEvent(context.getView().building.id, context.getView().queue.id, dataUrl));
			}
		});
	}
};

// ... /HANDLE

// /FUNCTIONS
