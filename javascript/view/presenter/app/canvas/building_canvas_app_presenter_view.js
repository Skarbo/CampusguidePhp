// CONSTRUCTOR

BuildingCanvasAppPresenterView.prototype = new BuildingCanvasPresenterView();

function BuildingCanvasAppPresenterView(view) {
	BuildingCanvasPresenterView.apply(this, arguments);
	this.positionShape = null;
	this.levelAnimate = true;
	this.lastSelected = view.selected;
};

// VARIABLES

BuildingCanvasAppPresenterView.LOCAL_VARIABLE_STAGE_SETTINGS = "stageSettingsApp";
BuildingCanvasAppPresenterView.POSITION_LAYER_Z_INDEX = 2000;
BuildingCanvasAppPresenterView.TYPE_POSITION = "position";

$(function() {

	BuildingCanvasAppPresenterView.SETUP_NAVIGATION = $.extend(true, {}, BuildingCanvasPresenterView.SETUP_NAVIGATION, {
		'attrs' : {
			'opacity' : 0.1
		}
	});
	
	BuildingCanvasAppPresenterView.SETUP_ELEMENT_ROOM = $.extend(true, {}, BuildingCanvasPresenterView.SETUP_ELEMENT_ROOM, {
		'shape' : {
			'selected' : {
				'fill' : "#C9DAF8",
				'strokeWidth': 4
			}
		}
	});

	BuildingCanvasAppPresenterView.SETUP = {};
	BuildingCanvasAppPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_FLOORS] = BuildingCanvasPresenterView.SETUP_FLOOR;
	BuildingCanvasAppPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS] = BuildingCanvasAppPresenterView.SETUP_ELEMENT_ROOM;
	BuildingCanvasAppPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_NAVIGATION] = BuildingCanvasAppPresenterView.SETUP_NAVIGATION;
});

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingAppMainController}
 */
BuildingCanvasAppPresenterView.prototype.getController = function() {
	return BuildingCanvasPresenterView.prototype.getController.call(this);
};

/**
 * @return {BuildingAppMainView}
 */
BuildingCanvasAppPresenterView.prototype.getView = function() {
	return BuildingCanvasPresenterView.prototype.getView.call(this);
};

/**
 * @return {DaoContainer}
 */
BuildingCanvasAppPresenterView.prototype.getDaoContainer = function() {
	return this.getController().getDaoContainer();
};

/**
 * @return {Object}
 */
BuildingCanvasAppPresenterView.prototype.getCanvasContentElement = function() {
	return this.getRoot().find("#building_canvas");
};

/**
 * @return {Object}
 */
BuildingCanvasAppPresenterView.prototype.getOverlayElementsElement = function() {
	return this.getRoot().find(".overlay_element");
};

BuildingCanvasAppPresenterView.prototype.getStageSettingsLocalVariable = function() {
	return BuildingCanvasAppPresenterView.LOCAL_VARIABLE_STAGE_SETTINGS;
};

/**
 * @returns {Object}
 */
BuildingCanvasAppPresenterView.prototype.getSetup = function(type) {
	return BuildingCanvasAppPresenterView.SETUP[type] || {};
};

// ... ... LIST ADAPTER

/**
 * @returns {ListAdapter}
 */
BuildingCanvasAppPresenterView.prototype.getBuildingList = function() {
	return this.getDaoContainer().getBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BuildingCanvasAppPresenterView.prototype.getBuildingFloorList = function() {
	return this.getDaoContainer().getFloorBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BuildingCanvasAppPresenterView.prototype.getBuildingElementList = function() {
	return this.getDaoContainer().getElementBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BuildingCanvasAppPresenterView.prototype.getBuildingNavigationList = function() {
	return this.getDaoContainer().getNavigationBuildingDao().getListAdapter();
};

// ... ... /LIST ADAPTER

/**
 * @return {Object}
 */
BuildingCanvasAppPresenterView.prototype.getCanvasLoaderElement = function() {
	return this.getRoot().find("#building_loader");
};

/**
 * @return {Object}
 */
BuildingCanvasAppPresenterView.prototype.getCanvasOverlayFloorsElement = function() {
	return this.getRoot().find("#building_canvas_overlay_floors");
};

/**
 * @return {Object}
 */
BuildingCanvasAppPresenterView.prototype.getCanvasOverlayZoomElement = function() {
	return this.getRoot().find("#building_canvas_overlay_zoom");
};

// ... /GET

// ... DO

BuildingCanvasAppPresenterView.prototype.doBindEventHandler = function() {
	BuildingCanvasPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS
	// /EVENTS

	// OVERLAY

	this.getCanvasOverlayFloorsElement().children().bind("touchclick", function(event) {
		context.getView().getController().updateHash({
			"floor" : $(this).attr("data-floor")
		});
		// event.preventDefault();
		// console.log("Click floor");
		// context.doFloorSelect($(this).attr("data-floor"));
	});

	this.getCanvasOverlayZoomElement().bind("touchclick", function(event) {
		var div = $(event.target).closest("div");
		if (div.attr("data-zoom-in") == "true")
			context.getEventHandler().handle(new ScaleEvent(true, true));
		else if (div.attr("data-zoom-in") == "false")
			context.getEventHandler().handle(new ScaleEvent(false, true));
	});
	this.getCanvasOverlayZoomElement().find("div").touchActive();

	// Elements
	this.getOverlayElementsElement().children().unbind("touchclick").bind("touchclick", function(event){
		var clicked = $(this);
		var elementId = clicked.parent().attr("data-element");
		console.log(clicked, elementId);
		if (clicked.hasClass("direction"))
		{
			context.doPositionNavigate(elementId);
		}
	}).touchActive();
	
	// /OVERLAY
	
	

};

BuildingCanvasAppPresenterView.prototype.doLevelSelect = function(levelId) {
	BuildingCanvasPresenterView.prototype.doLevelSelect.call(this, levelId);
	
	 var overlayFloors = this.getCanvasOverlayFloorsElement().children();
	 overlayFloors.removeClass("selected").filter("[data-floor=" + levelId + "]").addClass("selected");
};

BuildingCanvasAppPresenterView.prototype.doOverlayFloorSelectToggle = function() {
	this.getCanvasOverlayFloorsElement().parent().show();
	this.getCanvasOverlayFloorsElement().show();
};

BuildingCanvasAppPresenterView.prototype.doPositionSet = function() {
	var context = this;
	var positionLayer = this.getLayer(BuildingCanvasAppPresenterView.TYPE_POSITION, this.levelSelected);	
	this.positionShape.moveTo(positionLayer);
	positionLayer.moveToTop();
	positionLayer.draw();
	this.stage.on("touchend.position mousemove.position", function() {
		context.positionShape.setPosition(KineticjsUtil.getPointerRelativePosition(this));
		context.positionShape.show();
		context.positionShape.getLayer().draw();
	});
	this.positionShape.on("tap.position click.position", function(event) {
		event.preventDefault();
		context.handlePositionSet(event);
	});
};


BuildingCanvasAppPresenterView.prototype.doPositionNavigate = function(elementId) {
	var context =  this;
	
	if (this.positionShape.isVisible())
	{
		var floorId = this.levelSelected;
		var position = this.positionShape.getPosition();
		this.getController().getNavigateHandler().navigate(elementId, position, floorId, {
			success : function(navigate){
				context.handlePositionNavigate(navigate);
			},
			error : function(error)
			{
				context.getEventHandler(new ToastEvent("Could not calculate route"));
			}
		});
	}
	else
	{
		this.getEventHandler().handle(new ToastEvent("Position is not set"));
	}
};

BuildingCanvasAppPresenterView.prototype.doBuildingElementOverlay = function(buildingElementPolygon, elementId) {
	console.log("doBuildingElementOverlay", elementId);
	if (!elementId)
		return;
	
	this.getOverlayElementsElement().hide("hide");
	
	var overlayElement = this.getOverlayElementsElement().filter("[data-element=" + elementId + "]");
	if (overlayElement.length > 0)
	{
		overlayElement.show(); // overlayElement.removeClass("hide");
		overlayElement.offset({
			left : this.getRoot().position().left + (this.getRoot().width() / 2) - (overlayElement.width() / 2),
			top : this.getRoot().position().top + (this.getRoot().height() / 2) - overlayElement.height()
		});
		overlayElement.find(".pointer_wrapper .pointer").css("margin-left", (overlayElement.width() / 2));
		$(window).unbind(".buildingElementOverlay").one("mouseup.buildingElementOverlay, touchend.buildingElementOverlay", { 'overlayElement' : overlayElement }, function(event){			
// if ($(event.target).closest(event.data.overlayElement).length == 0)
// {
// }
			overlayElement.hide();
			$(window).unbind(".buildingElementOverlay");
		});
		console.log("Element", elementId);
		var centerElement = buildingElementPolygon.label.getPosition();
		if(centerElement)
		{				
// var pos = this.getPointerPosition();
// var relPos = KineticjsUtil.getPointerRelativePosition(this);
// console.log(pos, relPos, this.getWidth(), this.getHeight(),
// KineticjsUtil.getPointRelative(this, { x : 0, y : this.getWidth() / 2}),
// KineticjsUtil.getPointRelative(this, { x : this.getWidth(), y :
// this.getWidth() / 2}));
			var viewport = KineticjsUtil.getViewport(this.stage);
			var newpoint = { x : centerElement.x + this.stage.attrs.x - this.stage.attrs.offset.x, y : centerElement.y + this.stage.attrs.y - this.stage.attrs.offset.y };
// console.log("Viewport", viewport, "Center element", centerElement, "New
// point", newpoint, "Pos", this.stage.getPosition(), this.stage.getOffset());
// this.stage.setOffset(0,0);
// this.stage.setPosition(centerElement);
// this.stage.draw();
		}		
	}
};


// ... /DO

// ... HANDLE

// ... /HANDLE

// ... DRAW

BuildingCanvasAppPresenterView.prototype.draw = function(root) {
	BuildingCanvasPresenterView.prototype.draw.call(this, root);
	var context = this;

	// Stage click
	this.stage.on("click", function(event) {
		// context.handleStageClick(event);
	});

	// Stage doubletap
	this.stage.on("dbltap", function(event) {
		context.getEventHandler().handle(new ScaleEvent(true));
	});

	// Floors overlay
	this.getCanvasOverlayFloorsElement().offset(
			{
				top : this.getRoot().position().top + (this.getRoot().height() / 2)
						- (this.getCanvasOverlayFloorsElement().height() / 2),
				left : this.getRoot().position().left + this.getRoot().width() - this.getCanvasOverlayFloorsElement().outerWidth() - 10
			});
	this.getCanvasOverlayFloorsElement().children().touchActive();

	// Zoom overlay
	this.getCanvasOverlayZoomElement().offset({
		top : this.getRoot().position().top + this.getRoot().height() - this.getCanvasOverlayZoomElement().height() - 10,
		left : this.getRoot().position().left + this.getRoot().width() - this.getCanvasOverlayZoomElement().outerWidth() - 10
	});
	
	// TOUCH ZOOM

	// function getDistance(p1, p2) {
	// return Math.sqrt(Math.pow((p2.x - p1.x), 2) + Math.pow((p2.y - p1.y),
	// 2));
	// }
	//
	// var lastDist = 0;
	// this.stage.getContent().addEventListener('touchmove', function(evt) {
	// var touch1 = evt.touches[0];
	// var touch2 = evt.touches[1];
	//
	// if (touch1 && touch2) {
	// var dist = getDistance({
	// x : touch1.clientX,
	// y : touch1.clientY
	// }, {
	// x : touch2.clientX,
	// y : touch2.clientY
	// });
	//
	// if (!lastDist) {
	// lastDist = dist;
	// }
	//
	// var scale = context.stage.getScale().x * dist / lastDist;
	// // console.log("zooming", evt, scale);
	//
	// context.stage.setScale(scale);
	// context.stage.draw();
	// lastDist = dist;
	// }
	// }, false);
	//
	// this.stage.getContent().addEventListener('touchend', function() {
	// lastDist = 0;
	// context.setStageSettings();
	// }, false);

	// /TOUCH ZOOM

	// Set stage draggable
	// this.stage.setDraggable(true);
	
//	this.stage.setPosition(0, 0);
//	this.stage.setOffset(0, 0);
//	this.stage.setScale(1, 1);
//	this.setStageSettings();
//	this.stage.draw();
};

BuildingCanvasAppPresenterView.prototype.drawBuildingFloor = function(floor) {
	BuildingCanvasPresenterView.prototype.drawBuildingFloor.call(this, floor);
	this.doOverlayFloorSelectToggle();
	
	// Position shape
	var positionLayer = new Kinetic.Layer({'name' : "position_layer"});
	var positionGroup = new Kinetic.Group();
	this.positionShape = IconCanvasUtil.location({
		group : {
			visible : false
		}
	});
	var navigateGroup = new Kinetic.Group({
		'name' : "navigate_group",
		'id' : floor.id
	});
	
	this.stage.add(positionLayer);
	positionLayer.add(positionGroup);
	// positionGroup.add(this.positionShape);
	positionLayer.setZIndex(BuildingAppMainView.POSITION_LAYER_Z_INDEX);	
	positionLayer.add(navigateGroup);
	
	this.setLayer(BuildingCanvasAppPresenterView.TYPE_POSITION, floor.id, positionLayer);
};

BuildingCanvasAppPresenterView.prototype.drawBuildingNavigation = function(navigations) {
	BuildingCanvasPresenterView.prototype.drawBuildingNavigation.call(this, navigations);
};

// //
// // BuildingCanvasPresenterView.prototype.drawFloor = function(floor, width,
// // height) {
// // BuildingCanvasPresenterView.prototype.drawFloor.call(this, floor, width,
// // height);
// // var context = this;
// //
// // var polygons = this.getPolygons(BuildingCanvasPresenterView.TYPE_FLOORS,
// // floor.id);
// // if (!polygons)
// // return;
// //
// // // DRAW BOUND RECT
// //
// // var outerBoundsMax = {
// // x : 0,
// // y : 0
// // }, outerBounds = null;
// // for (i in polygons.children) {
// // outerBounds =
// // CanvasUtil.getOuterBounds(polygons.children[i].getCoordinates());
// // if (outerBounds[2][0] > outerBoundsMax.x)
// // outerBoundsMax.x = outerBounds[2][0];
// // if (outerBounds[3][1] > outerBoundsMax.y)
// // outerBoundsMax.y = outerBounds[3][1];
// // }
// //
// // if (!outerBoundsMax)
// // return;
// //
// // if (!this.layers.bound) {
// // this.layers.bound = new Kinetic.Layer({
// // name : "bound"
// // });
// //
// // this.layers.bound.add(new Kinetic.Rect({
// // x : 0,
// // y : 0,
// // height : 0,
// // width : 0
// // }));
// //
// // this.stage.add(this.layers.bound);
// // this.layers.bound.setZIndex(-10);
// // }
// // var boundRect = this.layers.bound.children[0];
// // if (!boundRect)
// // return;
// //
// // if (boundRect.getWidth() < outerBoundsMax.x)
// // boundRect.setWidth(outerBoundsMax.x);
// // if (boundRect.getHeight() < outerBoundsMax.y)
// // boundRect.setHeight(outerBoundsMax.y);
// //
// // // /DRAW BOUND RECT
// //
// // // BIND CLICK
// //
// // var polygon = null;
// // for (i in polygons.children) {
// // polygon = polygons.children[i];
// //
// // polygon.on("click", function(event) {
// // if (event.which == 1)
// // context.getEventHandler().handle(new SelectCanvasEvent());
// // });
// // }
// //
// // // /BIND CLICK
// //
// // };

// ... /DRAW

// ... HANDLE

BuildingCanvasAppPresenterView.prototype.handleStageClick = function(event) {
	console.log(KineticjsUtil.getPointerRelativePosition(this.stage));
	if (this.getView().isPositionSetting) {
		// event.preventDefault();
		// console.log("SET POS");
	} else {
		// console.log(event, this.stage.isDragging());
		// this.doOverlayFloorSelectToggle();
	}
};

BuildingCanvasAppPresenterView.prototype.handlePositionSet = function(event) {
	var context = this;
	this.positionShape.stopDrag();
	if (event.which == 3) {
		this.positionShape.hide();
		this.positionShape.getLayer().draw();
		return
	}
	
	this.stage.off(".position");
	this.positionShape.off(".position");
	this.positionShape.off(".poschange").on("dragend.poschange",function(){
		context.handlePositionChange();
	});
	this.handlePositionChange();
};

BuildingCanvasAppPresenterView.prototype.handlePositionChange = function() {
	
};

BuildingCanvasAppPresenterView.prototype.handlePositionNavigate = function(navigate) {
	console.log("BuildingCanvasAppPresenterView.handlePositionNavigate", navigate);
	var navigationElements = this.getElements(BuildingCanvasPresenterView.TYPE_NAVIGATION, this.levelSelected);
	if (navigationElements)
	{
		var navigationElement = navigationElements.getChildren()[0];
		if (navigationElement)
		{
			var navigateGroup = this.positionShape.getLayer().get(".navigate_group")[0];
			navigateGroup.removeChildren();
			
			var points = [];
			
			if (this.positionShape.isVisible())
				points.push(this.positionShape.getPosition());
			
			for(var i in navigate)
			{
				var node = navigationElement.getAnchor(navigate[i]);
				if (node)
					points.push(node.getPosition());
			}
			
			console.log("Navigation line points", points); 
			
			var navigateLine = new Kinetic.Line({
		        points: points,
		        stroke: '#6685FF',
		        strokeWidth: 4,
		        lineJoin: 'round'
		      });
			navigateGroup.add(navigateLine);
			navigateGroup.getLayer().moveToTop();
			navigateGroup.getLayer().draw();			
		}
	}
};

BuildingCanvasAppPresenterView.prototype.handleSelectCanvas = function(type, element) {
	BuildingCanvasPresenterView.prototype.handleSelectCanvas.call(this, type, element);
	console.log("Handle select canvas", type, element, this.lastSelected);
	
	if (!this.lastSelected || this.lastSelected.element == null) {
		this.lastSelected = this.getView().selected;
		return;
	}
	
	switch (type) {
	case "polygon":
		if (element.type == "building_element_polygon" && this.lastSelected.element.type == element.type && this.lastSelected.element._id == element._id)
		{
			this.doBuildingElementOverlay(element, element.element ? element.element.id : null);
		}
		break;
	}
	this.lastSelected = this.getView().selected;	
};

BuildingCanvasAppPresenterView.prototype.handleLoaded = function() {
	BuildingCanvasPresenterView.prototype.handleLoaded.call(this);
	console.log("Handle loaded");
	if (this.getController().getHash().position)
	{
		var buildingElementPolygon = this.getBuildingElementElements(this.getController().getHash().position);
		if (buildingElementPolygon)
		{
			var positionLayer = this.getLayer(BuildingCanvasAppPresenterView.TYPE_POSITION, this.levelSelected);	
			this.positionShape.moveTo(positionLayer);
			
			var centerElement = buildingElementPolygon.label.getPosition();
			if(centerElement)
			{	
				console.log("setting pos shape to", centerElement);
				this.positionShape.show();
				this.positionShape.setPosition(centerElement);
				this.positionShape.move(0, 20);
				positionLayer.moveToTop();
				positionLayer.draw();			
			}
			else
				console.error("Element doe snot have label");
		}
		else
			console.error("Could not find element at", this.getController().getHash().position);
	}
};

// BuildingCanvasAppPresenterView.prototype.handleSelect = function(type,
// object) {
// BuildingCanvasPresenterView.prototype.handleSelect.call(this, type, object);
// switch (type) {
// case "element":
// var elementElement = this.getBuildingElementElements(object.id);
// if (elementElement)
// this.handleSelectCanvas("polygon", elementElement);
// break;
// }
// };

// ... /HANDLE

// ... CREATE

BuildingCanvasAppPresenterView.prototype.createLocationShape = function(event) {
};

// ... /CREATE

// /FUNCTIONS
