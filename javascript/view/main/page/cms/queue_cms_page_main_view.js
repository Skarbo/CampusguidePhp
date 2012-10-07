// CONSTRUCTOR
QueueCmsPageMainView.prototype = new PageMainView();

function QueueCmsPageMainView(view, queue) {
	PageMainView.apply(this, arguments);
	this.queue = queue;
	this.building = null;
	this.floors = {};
	this.elements = {};
	this.queueCanvas = new QueueCmsCanvasPresenterView(this);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {CmsMainView}
 */
QueueCmsPageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

/**
 * @return {Object}
 */
QueueCmsPageMainView.prototype.getBuilding = function() {
	return this.building;
};

/**
 * @return {Object}
 */
QueueCmsPageMainView.prototype.getFloors = function() {
	return this.floors;
};

/**
 * @return {Object}
 */
QueueCmsPageMainView.prototype.getElements = function() {
	return this.elements;
};

// ... /GET

// ... DO

QueueCmsPageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENTS

	// Retrieved event
	this.getView().getController().getEventHandler().registerListener(RetrievedEvent.TYPE,
	/**
	 * @param {RetrievedEvent}
	 *            event
	 */
	function(event) {
		switch (event.getRetrievedType()) {
		case "building_queue":
			context.building = event.getRetrieved();
			break;

		case "building_floors_queue":
			context.floors = event.getRetrieved();
			break;

		case "building_elements_queue":
			context.elements = event.getRetrieved();
			break;
		}
	});

	// /EVENTS
};

// ... /DO

/**
 * @param {Element}
 *            root
 */
QueueCmsPageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);

	// Set canvas wrapper width and height
	this.getRoot().width(this.queue.arguments.size[0]).height(this.queue.arguments.size[1]);
	
	// Draw Queue canvas
	this.queueCanvas.draw(this.getRoot());
};

// /FUNCTIONS
