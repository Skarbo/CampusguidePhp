// CONSTRUCTOR
MenuBuildingcreatorCmsPresenterView.prototype = new PresenterView();

function MenuBuildingcreatorCmsPresenterView(view) {
	PresenterView.apply(this, arguments);
};

// VARIABLES

MenuBuildingcreatorCmsPresenterView.TYPE_FLOORS = "floors";
MenuBuildingcreatorCmsPresenterView.TYPE_ELEMENTS = "elements";
MenuBuildingcreatorCmsPresenterView.TYPE_NAVIGATION = "navigation";

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {Object}
 */
MenuBuildingcreatorCmsPresenterView.prototype.getMenuSubElement = function() {
	return this.getRoot().find("[data-menu]");
};

/**
 * @returns {Object}
 */
MenuBuildingcreatorCmsPresenterView.prototype.getMenuSaveElement = function() {
	return this.getRoot().find("#save");
};

// ... /GET

// ... DO

MenuBuildingcreatorCmsPresenterView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENTS

	// Menu event
	this.getEventHandler().registerListener(MenuEvent.TYPE,
	/**
	 * @param {MenuEvent}
	 *            event
	 */
	function(event) {
		context.handleMenuSelect(event.getMenu(), event.getSidebar());
	});

	// Add history event
	this.getView().getController().getEventHandler().registerListener(AddHistoryEvent.TYPE,
	/**
	 * @param {AddHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistory();
	});

	// Undo history event
	this.getView().getController().getEventHandler().registerListener(UndoHistoryEvent.TYPE,
	/**
	 * @param {UndoHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistory();
	});

	// /EVENTS

	// MENU

	this.getMenuSaveElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new SaveEvent("building"));
	});

	this.getMenuSubElement().click(function(event) {
		if (!$(this).isDisabled()) {
			// Update hash
			context.getView().getController().updateHash({
				"menu" : $(this).attr("data-menu")
			});
		}
	});

	// /MENU

};

// ... /DO

// ... HANDLE

MenuBuildingcreatorCmsPresenterView.prototype.handleMenuSelect = function(menu, sidebar) {
	var submenuElements = this.getMenuSubElement();

	submenuElements.removeClass("highlight");

	switch (menu) {
	case MenuBuildingcreatorCmsPresenterView.TYPE_ELEMENTS:
	case MenuBuildingcreatorCmsPresenterView.TYPE_NAVIGATION:
		submenuElements.filter("[data-menu=" + menu + "]").addClass("highlight");
		break;

	default:
		menu = MenuBuildingcreatorCmsPresenterView.TYPE_FLOORS;
		submenuElements.filter("[data-menu=floors]").addClass("highlight");
		break;
	}
	this.menu = menu;

};

MenuBuildingcreatorCmsPresenterView.prototype.handleHistory = function() {
	var context = this;
	setTimeout(function() {
		if (context.getView().canvasPresenter.history.length == 0)
			context.getMenuSaveElement().disable();
		else
			context.getMenuSaveElement().enable();
	}, 10);
};

// ... /HANDLE

MenuBuildingcreatorCmsPresenterView.prototype.draw = function(root) {
	PresenterView.prototype.draw.call(this, root);

	// Select menu
	this.handleMenuSelect(this.getController().getHash().menu);
};

// /FUNCTIONS
