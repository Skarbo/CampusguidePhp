// CONSTRUCTOR
MenuBuildingcreatorBuildingsCmsPresenterView.prototype = new AbstractPresenterView();

function MenuBuildingcreatorBuildingsCmsPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
};

// VARIABLES

MenuBuildingcreatorBuildingsCmsPresenterView.TYPE_FLOORS = "floors";
MenuBuildingcreatorBuildingsCmsPresenterView.TYPE_ELEMENTS = "elements";
MenuBuildingcreatorBuildingsCmsPresenterView.TYPE_NAVIGATION = "navigation";

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {Object}
 */
MenuBuildingcreatorBuildingsCmsPresenterView.prototype.getMenuSubElement = function() {
	return this.getRoot().find("[data-menu]");
};

/**
 * @returns {Object}
 */
MenuBuildingcreatorBuildingsCmsPresenterView.prototype.getMenuSaveElement = function() {
	return this.getRoot().find("#save");
};

// ... /GET

// ... DO

MenuBuildingcreatorBuildingsCmsPresenterView.prototype.doBindEventHandler = function() {
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
	this.getView().getController().getEventHandler().registerListener(UndidHistoryEvent.TYPE,
	/**
	 * @param {UndidHistoryEvent}
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

MenuBuildingcreatorBuildingsCmsPresenterView.prototype.handleMenuSelect = function(menu, sidebar) {
	var submenuElements = this.getMenuSubElement();

	submenuElements.removeClass("highlight");

	switch (menu) {
	case MenuBuildingcreatorBuildingsCmsPresenterView.TYPE_ELEMENTS:
	case MenuBuildingcreatorBuildingsCmsPresenterView.TYPE_NAVIGATION:
		submenuElements.filter("[data-menu=" + menu + "]").addClass("highlight");
		break;

	default:
		menu = MenuBuildingcreatorBuildingsCmsPresenterView.TYPE_FLOORS;
		submenuElements.filter("[data-menu=floors]").addClass("highlight");
		break;
	}
	this.menu = menu;

};

MenuBuildingcreatorBuildingsCmsPresenterView.prototype.handleHistory = function() {
	var context = this;
	setTimeout(function() {
		if (context.getView().history.length == 0)
			context.getMenuSaveElement().disable();
		else
			context.getMenuSaveElement().enable();
	}, 10);
};

// ... /HANDLE

MenuBuildingcreatorBuildingsCmsPresenterView.prototype.draw = function(root) {
	AbstractPresenterView.prototype.draw.call(this, root);

	// Select menu
	if (!this.getController().getHash().menu)
		this.handleMenuSelect(this.getController().getHash().menu);
};

// /FUNCTIONS
