// CONSTRUCTOR
MenuBuildingcreatorCmsCampusguidePresenterView.prototype = new PresenterView();

function MenuBuildingcreatorCmsCampusguidePresenterView(view) {
	PresenterView.apply(this, arguments);
};

// VARIABLES

MenuBuildingcreatorCmsCampusguidePresenterView.TYPE_FLOORS = "floors";
MenuBuildingcreatorCmsCampusguidePresenterView.TYPE_ELEMENTS = "elements";
MenuBuildingcreatorCmsCampusguidePresenterView.TYPE_NAVIGATION = "navigation";

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {Object}
 */
MenuBuildingcreatorCmsCampusguidePresenterView.prototype.getMenuSubElement = function() {
	return this.getRoot().find("[data-menu]");
};

/**
 * @returns {Object}
 */
MenuBuildingcreatorCmsCampusguidePresenterView.prototype.getMenuSaveElement = function() {
	return this.getRoot().find("#save");
};

// ... /GET

// ... DO

MenuBuildingcreatorCmsCampusguidePresenterView.prototype.doBindEventHandler = function() {
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

MenuBuildingcreatorCmsCampusguidePresenterView.prototype.handleMenuSelect = function(menu, sidebar) {
	var submenuElements = this.getMenuSubElement();

	submenuElements.removeClass("highlight");

	switch (menu) {
	case MenuBuildingcreatorCmsCampusguidePresenterView.TYPE_ELEMENTS:
	case MenuBuildingcreatorCmsCampusguidePresenterView.TYPE_NAVIGATION:
		submenuElements.filter("[data-menu=" + menu + "]").addClass("highlight");
		break;

	default:
		menu = MenuBuildingcreatorCmsCampusguidePresenterView.TYPE_FLOORS;
		submenuElements.filter("[data-menu=floors]").addClass("highlight");
		break;
	}
	this.menu = menu;

};

MenuBuildingcreatorCmsCampusguidePresenterView.prototype.handleHistory = function() {
	var context = this;
	setTimeout(function() {
		if (context.getView().canvasPresenter.history.length == 0)
			context.getMenuSaveElement().disable();
		else
			context.getMenuSaveElement().enable();
	}, 10);
};

// ... /HANDLE

MenuBuildingcreatorCmsCampusguidePresenterView.prototype.draw = function(root) {
	PresenterView.prototype.draw.call(this, root);

	// Select menu
	this.handleMenuSelect(this.getController().getHash().menu);
};

// /FUNCTIONS
