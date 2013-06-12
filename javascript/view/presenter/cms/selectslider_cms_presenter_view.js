// CONSTRUCTOR
SelectsliderCmsPresenterView.prototype = new AbstractPresenterView();

function SelectsliderCmsPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
	this.template = null;
	this.id = null;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

SelectsliderCmsPresenterView.prototype.getInputElement = function() {
	return this.getRoot().find("input[name=" + this.id + "]");
};

SelectsliderCmsPresenterView.prototype.getSelectedElement = function() {
	return this.getRoot().find(".selectslider_selected");
};

SelectsliderCmsPresenterView.prototype.getNoneElement = function() {
	return this.getRoot().find(".selectslider_selected_none");
};

SelectsliderCmsPresenterView.prototype.getContentsElement = function() {
	return this.getRoot().find(".selectslider_contents_wrapper .selectslider_content_wrapper");
};

// ... /GET

// ... DO

SelectsliderCmsPresenterView.prototype.doBindEventHandler = function() {
	AbstractPresenterView.prototype.doBindEventHandler.call(this);
	
	this.doRebind();

	// if (input.val()) {
	// var facilityId = input.val();
	// var facilityWrapperId = Core.sprintf("facility_%s", facilityId);
	// var facilitySelectedElement = $(Core.sprintf(".facility_wrapper#%s",
	// facilityWrapperId));
	//
	// if (facilitySelectedElement.length > 0) {
	// facilitySelectedElement.addClass("selected");
	//
	// selectedFacilityElement.css("display", "table-cell");
	// selectedFacilityElement.empty();
	// selectedFacilityElement.append(facilitySelectedElement.clone());
	//
	// noneFacilityElement.hide();
	// }
	// }
};

// ... /DO

SelectsliderCmsPresenterView.prototype.doContentsRemove = function() {
	this.getRoot().find(".selectslider_content").find(":not(.fill)").remove();
	this.getSelectedElement().empty();
	this.getSelectedElement().addClass("hide");
	this.getNoneElement().removeClass("hide");
	this.getInputElement().val(0);
};

SelectsliderCmsPresenterView.prototype.doContentAdd = function(id, title) {
	var content = this.template.clone();
	content.find(".selectslider_content_wrapper").attr("data-id", id);
	var anchor = content.find(".name a");
	var image = content.find(".image");
	anchor.text(title).attr("href", Core.sprintf(anchor.attr("href"), id));
	image.attr("title", title).attr("style", Core.sprintf(image.attr("style"), id));
	this.getRoot().find(".selectslider_content .fill").before(content);
};

SelectsliderCmsPresenterView.prototype.doSlider = function() {
	this.getRoot().find(".selectslider_content").slider();
};

SelectsliderCmsPresenterView.prototype.doRebind = function() {
	var context = this;
	
	var input = this.getInputElement();
	var selectedElement = this.getSelectedElement();
	var noneElement = this.getNoneElement();
		
	this.getContentsElement().click(function(event) {
		var target = $(event.delegateTarget);
		var contentId = parseInt(target.attr("data-id"));
		context.getRoot().find(".selectslider_content_wrapper").removeClass("selected");
		target.addClass("selected");
		input.val(contentId);
		input.change();

		selectedElement.removeClass("hide");
		selectedElement.empty();
		selectedElement.append(target.clone());

		noneElement.addClass("hide");
	});
};

SelectsliderCmsPresenterView.prototype.draw = function(root) {
	this.id = root.attr("id");
	AbstractPresenterView.prototype.draw.call(this, root);
	this.template = $(this.getRoot().find(".selectslider_template").children()[0]);
	this.doSlider();
};

// /FUNCTIONS
