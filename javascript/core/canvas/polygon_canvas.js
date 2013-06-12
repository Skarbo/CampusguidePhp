/**
 * Kinetic Polygon extention
 */

var Polygon, PolygonShape, PolygonAnchor, PolygonAnchorControl, PolygonAnchorPoint, PolygonAnchorHandle;
$(function() {

	// Kinetic must exist
	if (typeof Kinetic === "undefined")
		return console.warn("Kinetic is not loaded");

	/**
	 * Polygon Anchor
	 * 
	 * @param {Polygon}
	 *            polygon
	 */
	PolygonAnchor = function(config, polygon) {
		if (typeof polygon != "object")
			return console.error("PolygonAnchor: Parent Polygon is not an object");

		config = config || {};

		Kinetic.Circle.call(this, $.extend(true, {
			name : "polygon_anchor",
			x : 0,
			y : 0,
			radius : 8,
			stroke : "#666",
			strokeWidth : 2,
			draggable : true,
			visible : false,
			selected : {
				strokeWidth : 2,
			}
		}, polygon.setup["anchor"], config));

		this.polygon = polygon;
		this.next = null;
		this.prev = null;
		this.isSelected = false;
		this.positionPrev = [];

		// ... ON

		this.on("dragstart", function(event) {
			this.positionPrev.push(this.getPosition());
		});
		this.on("dragend", function(event) {
			event.cancelBubble = true;
			this.moveToTop();
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				if (!this.polygon.isCreating) {
					this.getStage().fire("change", {
						node : this,
						type : "moved"
					});
				}
				this.polygon.changed = true;
				this.polygon.updateControlLine(null);
				this.polygon.getLayer().draw();
			}
		});
		this.on("dragmove", function(event) {
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				if (this.prev) {
					if (!event.shiftKey && Math.abs(this.attrs.x - this.prev.attrs.x) < 5)
						this.attrs.x = this.prev.attrs.x;
					if (!event.shiftKey && Math.abs(this.attrs.y - this.prev.attrs.y) < 5)
						this.attrs.y = this.prev.attrs.y;
				}
				if (this.next) {
					if (!event.shiftKey && Math.abs(this.attrs.x - this.next.attrs.x) < 5)
						this.attrs.x = this.next.attrs.x;
					if (!event.shiftKey && Math.abs(this.attrs.y - this.next.attrs.y) < 5)
						this.attrs.y = this.next.attrs.y;
				}
				this.polygon.updateControlLine(this);
			}
		});

		this.on("mouseover", function() {
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				$(this.polygon.getStage().content).css("cursor", "pointer");
			}
		});
		this.on("mouseout", function() {
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				$(this.polygon.getStage().content).css("cursor", "default");
			}
		});

		this.on("click", function(event) {
			// event.cancelBubble = true;
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				if (!this.polygon.isCreating) {
					if (event.which == 1) {
						this.getStage().fire("select", {
							'type' : 'polygon_anchor',
							'node' : this
						});
					} else if (event.which == 3 && this.isSelected) {
						this.getStage().fire("delete", {
							'type' : 'polygon_anchor',
							'node' : this
						});
						this.polygon.removeAnchor(this);
						this.polygon.updateShape();
						this.polygon.getLayer().draw();
					}
				}
			}
		});
		this.on("dblclick", function(event) {
			event.cancelBubble = true;
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				if (event.which == 1 && !this.polygon.isCreating && this.isSelected) {
					this.polygon.createPolygon(null, this);
				}
			}
		});

		// ... /ON

	};
	PolygonAnchor.prototype = {
		undoMove : function() {
			var posPrev = this.positionPrev.pop();
			if (posPrev) {
				this.setPosition(posPrev);
				this.polygon.updateShape();
			}
		},
		removeAnchor : function() {
			if (this.next && this.prev) {
				this.prev.next = this.next;
				this.next.prev = this.prev;
			} else if (this.prev) {
				this.prev.next = null;
			} else if (this.next) {
				this.next.prev = null;
			}
			this.destroy();
		},
		select : function() {
			this.setAttrs(this.attrs['selected']);
			this.isSelected = true;
		},
		deselect : function() {
			this.setAttrs(this.polygon.setup["anchor"]);
			this.isSelected = false;
		},
		erase : function() {
			this.polygon.removeAnchor(this);
		},
		undo : function() {
			console.log("PolygonAnchor.undo", this);
			this.polygon.addAnchorAfter(this, this.prev);
		},
		toData : function() {
			var data = [];

			var position = this.getPosition();
			data.push(Core.roundNumber(position.x, 2));
			data.push(Core.roundNumber(position.y, 2));

			return data;
		},
		fromData : function(data) {
			if (!jQuery.isArray(data))
				return console.error("PolygonAnchor.fromData: Data is not array", data);

			if (data.length >= 2) {
				this.setX(parseFloat(data[0]));
				this.setY(parseFloat(data[1]));
			}
		},
		getCoordinates : function() {
			var position = this.getPosition();
			return [ Core.roundNumber(position.x, 2), Core.roundNumber(position.y, 2) ];
		},
		updateSetup : function() {
			this.setAttrs(this.polygon.setup["anchor"]);
			// this.setDraggable(this.polygon.setup.mode == Polygon.MODE_EDIT);
		}
	};
	Kinetic.Util.extend(PolygonAnchor, Kinetic.Circle);

	/** /Polygon Anchor */

	/**
	 * Polygon shape
	 * 
	 * @param {Polygon}
	 *            polygon
	 */
	PolygonShape = function(config, polygon) {
		config = config || {};
		Kinetic.Polygon.call(this, $.extend(true, {
			name : "polygon_shape",
			stroke : "red",
			strokeWidth : 2,
			lineJoin : "round",
			fill : "#999",
			points : [ 0, 0, 0, 0 ]
		}, polygon.setup['shape'], config));

		this.polygon = polygon;
		this.selected = false;

		// ... ON

		this.on("click touchend", function(event) {
			this.handleClick(event);
		});

		this.on("mouseover", function() {
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				$(this.polygon.getStage().content).css("cursor", "pointer");
			}
		});
		this.on("mouseout", function() {
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				$(this.polygon.getStage().content).css("cursor", "default");
			}
		});

		// ... /ON

	};
	PolygonShape.prototype = {
		updateSetup : function() {
			this.setAttrs(this.polygon.setup["shape"]);
		},
		select : function() {
			this.setAttrs(this.polygon.setup['shape']['selected']);
		},
		deselect : function() {
			this.setAttrs(this.polygon.setup['shape']);
		},
		handleClick : function(event) {
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				if (!this.polygon.isCreating) {
					event.cancelBubble = true;
					this.getStage().fire("select", {
						'type' : "polygon",
						'node' : this.polygon
					});
				}
			}
		}
	};
	Kinetic.Util.extend(PolygonShape, Kinetic.Polygon);

	/**
	 * Polygon label
	 */
	PolygonLabel = function(config, polygon) {
		if (typeof polygon != "object")
			return console.error("PolygonLabel: Parent Polygon is not an object");

		config = config || {};
		Kinetic.Label.call(this, $.extend(true, {
			name : "polygon_label",
			// text : {
			// text : 'Label',
			// fontSize : 8,
			// padding : 2,
			// fill : 'white',
			// fontFamily : "Verdana,Arial,Helvetica,sans-serif"
			// },
//			rect : {
//				fill : 'black',
//				opacity : 0.5,
//			},
			draggable : false,
			visible : false,
			cornerRadius : 10
		}, polygon.setup['label'], config));

		this.add(new Kinetic.Tag({
			fill : 'black',
			opacity : 0.5,
		}));
		
		this.add(new Kinetic.Text({
			text : 'Label',
			fontSize : 8,
			padding : 2,
			fill : 'white',
			fontFamily : "Verdana,Arial,Helvetica,sans-serif"
		}));

		this.polygon = polygon;
		this.isPlaced = false;
		this.icon = null;
		this.noText = false;

		this.setDraggable(this.polygon.setup.mode == Polygon.MODE_EDIT);

		// ... ON

		this.on("dragend", function(event) {
			event.cancelBubble = true;
			this.moveToTop();
			this.isPlaced = true;
			this.polygon.changed = true;

			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				this.getStage().fire("change", {
					node : this,
					type : "moved"
				});
			}
		});
		this.on("mouseover", function() {
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				$(this.polygon.getStage().content).css("cursor", "pointer");
			}
		});
		this.on("mouseout", function() {
			if (this.polygon.setup.mode == Polygon.MODE_EDIT) {
				$(this.polygon.getStage().content).css("cursor", "default");
			}
		});

		// ... /ON

	};
	PolygonLabel.prototype = {
		updateSetup : function() {
			this.setAttrs(this.polygon.setup["label"]);
			this.setDraggable(this.polygon.setup.mode == Polygon.MODE_EDIT);
		},
		setLabelText : function() {
			this.getText().setText("Polygon");
			this.getText().setFontStyle("italic");
		},
		setIcon : function(icon) {
			if (icon) {
				if (this.icon)
					this.icon.destroy();
				this.icon = icon;
				this.add(icon);
			}
			if (this.icon) {
				this.icon.setPosition((this.getWidth() / 2) - (icon.getWidth() / 2), (icon.getHeight() * -1) - 5);
			}
		},
		drawText : function(notPlaced) {
			notPlaced = notPlaced || false;
			if (!this.polygon.setup['label'].visible)
				return;

			if (this.polygon.anchors.children.length < 2) {
				this.hide();
				return;
			}

			if (this.noText && this.polygon.setup.mode != Polygon.MODE_EDIT) {
				this.setOffset(0, this.getTag().getHeight());
				this.getText().hide();
				this.getTag().hide();
			}

			this.setLabelText();

			// Label is placed
			if (this.isPlaced && !notPlaced) {
				this.show();
				return;
			}

			var coordinates = this.polygon.getCoordinates();
			var polygonCenter = CanvasUtil.centerCoordinates(coordinates);
			var bounds = CanvasUtil.getMaxBounds(coordinates);

			this.setWidth(bounds[2] - bounds[0]);
			this.setHeight(bounds[3] - bounds[1]);

			this.setX(polygonCenter[0] - (this.getText().getTextWidth() / 2));
			this.setY(polygonCenter[1]);

			this.show();
		},
		toData : function() {
			if (!this.getVisible())
				return null;

			var coordinate = this.getPosition();
			return [ Core.roundNumber(coordinate.x, 2), Core.roundNumber(coordinate.y, 2) ];
		},
		fromData : function(data) {
			if (jQuery.isArray(data)) {
				this.isPlaced = true;
				var x = parseFloat(data[0]);
				var y = parseFloat(data[1]);
				this.setPosition(x, y);
			}
			this.drawText();
		}
	};
	Kinetic.Util.extend(PolygonLabel, Kinetic.Label);

	/** /PolygonLabel */

	/**
	 * Polygon
	 */
	Polygon = function(config, setup) {
		config = config || {};

		setup = $.extend(true, {}, {
			'shape' : {},
			'anchor' : {},
			'label' : {},
			'controlline' : {},
			'mode' : Polygon.MODE_SHOW,
		}, setup);

		Kinetic.Group.call(this, $.extend(true, {
			name : "polygon"
		}, config));

		this.type = "polygon";
		this.setup = setup;
		this.anchorFirst = null;
		this.anchorLast = null;
		this.anchorDraw = null;
		this.isSelected = false;
		this.isCreating = false;
		this.deleted = false;
		this.changed = false;
		this.object = {
			type : null,
			node : null
		};

		// ... NODES

		this.shape = this.createShape();

		this.anchors = new Kinetic.Group({
			name : "anchors"
		});

		this.controlLine = new Kinetic.Line({
			name : "polygon_controlline",
			points : [ 0, 0, 0, 0 ],
			stroke : "grey",
			strokeWidth : 2,
			lineJoin : "round",
			visible : false,
			dashArray : [ 10, 10, 0, 10 ]
		});
		this.controlLine.setAttrs(setup["controlline"]);

		this.label = this.createLabel({});

		this.add(this.shape);
		this.add(this.anchors);
		this.add(this.label);
		this.add(this.controlLine);

		// ... /NODES

		// ... ON

		// ... /ON

	};
	Polygon.prototype = {
		addAnchor : function(anchor) {
			if (!anchor)
				return;
			if (!this.anchorFirst) {
				this.anchorFirst = anchor;
				this.anchorLast = anchor;
			} else {
				anchor.prev = this.anchorLast;
				this.anchorLast.next = anchor;
				this.anchorLast = anchor;
				anchor.next = this.anchorFirst;
				this.anchorFirst.prev = anchor;
			}
			this.anchors.add(anchor);
			anchor.polygon = this;
			this.updateShape();
		},
		addAnchorAfter : function(anchor, anchorAfter) {
			if (!anchor)
				return;
			if (!anchorAfter || anchorAfter._id == this.anchorLast._id) {
				this.addAnchor(anchor);
				return;
			}
			if (anchorAfter.next) {
				anchorAfter.next.prev = anchor;
			}
			anchor.next = anchorAfter.next;
			anchor.prev = anchorAfter;
			anchorAfter.next = anchor;

			this.anchors.add(anchor);
			anchor.polygon = this;
			this.updateShape();
		},
		removeAnchor : function(anchor) {
			if (this.anchors.isAncestorOf(anchor)) {
				if (this.anchorFirst._id == anchor._id)
					this.anchorFirst = anchor.next;
				if (this.anchorLast._id == anchor._id)
					this.anchorLast = anchor.prev;
				anchor.removeAnchor();

				if (this.anchors.getChildren().length <= 1)
					this.erase();

				this.updateShape();
				this.getLayer().draw();
			}
		},
		eachAnchor : function(callback) {
			if (!this.anchorFirst)
				return false;

			var anchor = this.anchorFirst;
			do {
				callback(anchor);
				anchor = anchor.next;
			} while (anchor && anchor._id != this.anchorFirst._id);
		},
		createPolygon : function(event, anchorResume) {
			var namespace = "mousemove.draw_polygon mouseup.draw_polygon";
			var positionRelative = KineticjsUtil.getPointerRelativePosition(this.getStage());
			var position = positionRelative ? positionRelative : {
				x : 0,
				y : 0
			};
			this.changed = true;

			// New anchor
			if (!event) {
				var context = this;
				this.isCreating = true;

				// Create anchor
				this.anchorDraw = new PolygonAnchor(position, this);
				if (anchorResume) {
					this.addAnchorAfter(this.anchorDraw, anchorResume);
				} else {
					this.addAnchor(this.anchorDraw);
					this.anchorDraw.hide();
				}

				// Bind events
				this.getLayer().off(namespace);
				this.getLayer().on(namespace, function(event) {
					context.createPolygon(event, anchorResume);
				});
			} else if (positionRelative) {
				event.cancelBubble = true;

				// Move anchor
				if (event.type == "mousemove" && this.anchorDraw) {
					this.anchorDraw.show();
					if (!this.anchorDraw.isDragging()) {
						this.anchorDraw.setPosition(position);
						this.anchorDraw.startDrag();
					}
					// this.anchorDraw.show();
					// this.anchorDraw.setPosition(position);

					// this.getLayer().draw();
				}
				// Place anchor
				else if (event.type == "mouseup") {
					if (this.getStage().isDragging())
						return;
					console.log("Polygonc reate mouseup", event);
					this.anchorDraw.stopDrag();

					// Cancel placing
					if (event.which == 3) {
						// event.preventDefault();
						// //this.removeAnchor(this.anchorDraw);
						// this.getLayer().off(namespace);
						// this.anchorDraw = null;
						// //delete this.anchorDraw;
						// this.isCreating = false;
						// anchorResume = null;
						// this.getLayer().draw();
						// console.log("Cancel placing");
						// return;
						event.preventDefault();
						this.removeAnchor(this.anchorDraw);
						this.getLayer().off(namespace);
						this.anchorDraw = null;
						this.isCreating = false;
						anchorSibling = null;
						this.getStage().fire("change", {
							node : this,
							type : "created"
						});
						this.bind();
						this.updateControlLine(null);
						this.getLayer().draw();
						return;
					}

					// Create anchor
					// anchorResume = this.anchorDraw;
					// this.anchorDraw = new PolygonAnchor({
					// x: position.x,
					// y: position.y
					// }, this);
					// if (anchorResume) {
					// this.addAnchorAfter(this.anchorDraw, anchorResume);
					// } else {
					// this.addAnchor(this.anchorDraw);
					// }

					anchorResume = this.anchorDraw;
					this.anchorDraw = new PolygonAnchor(position, this);
					if (anchorResume) {
						this.addAnchorAfter(this.anchorDraw, anchorResume);
					} else {
						this.addAnchor(this.anchorDraw);
					}
					this.anchorDraw.startDrag();
				}
			}
		},
		toData : function() {
			var data = {
				coordinates : this.getCoordinates(),
				center : this.label.toData(),
				changed : this.changed,
				deleted : this.deleted
			};
			return data;
		},
		fromData : function(data) {
			if (typeof data != "object")
				return console.error("Polygon.fromData: Data is not object", object);
			var anchor = null;
			for (i in data.coordinates) {
				anchor = new PolygonAnchor({}, this);
				this.addAnchor(anchor);
				anchor.fromData(data.coordinates[i]);
			}

			this.label.fromData(data.center);
			this.label.drawText();

			this.createLabelIcon();

			this.updateShape();
		},
		getCoordinates : function() {
			var coordinates = [];
			this.eachAnchor(function(anchor) {
				coordinates.push(anchor.getCoordinates());
			});
			return coordinates;
		},
		copy : function() {
			var data = this.toData();
			var polygon = new Polygon({}, this.setup);
			polygon.fromData(data);
			return polygon;
		},
		select : function() {
			this.moveToTop();
			this.shape.select();
			this.isSelected = true;
		},
		deselect : function() {
			this.shape.deselect();
			this.isSelected = false;
		},
		erase : function() {
			this.hide();
			this.deleted = true;
		},
		undo : function() {
			this.show();
			this.deleted = false;
			this.getLayer().draw();
		},
		undoMove : function() {
			if (this.positionPrev) {
				this.setPosition(this.positionPrev);
				this.getLayer().draw();
			}
		},
		bind : function() {
			if (!this.getStage())
				return console.error("Polygon.bind: Stage is null");
			var context = this;

			// Change
			this.getStage().on("change", function(event) {
				if (!context.isVisible() || !event.node.polygon || event.node.polygon._id != context._id)
					return;

				if (event.node.attrs.name != "polygon_label") {
					context.label.drawText();
					context.getLayer().draw();
				}

			});

			// Setup
			this.getLayer().on("setup", function(event) {
				if (event.type == "polygon") {
					context.updateSetup(event.setup);
				}
			});

			// Draw text
			this.label.drawText();

		},
		updateSetup : function(setup) {
			this.setup = $.extend(true, {}, this.setup, setup);

			// Shape
			this.shape.updateSetup();

			// Anchor
			this.anchors.getChildren().each(function(shape) {
				shape.updateSetup();
			});
			// for ( var i in this.anchors.getChildren()) {
			// this.anchors.getChildren()[i].updateSetup();
			// }

			// Label
			this.label.updateSetup();

			this.getLayer().draw();
		},
		createLabel : function(config) {
			return new PolygonLabel(config, this);
		},
		createLabelIcon : function() {

		},
		createShape : function(config) {
			return new PolygonShape(config, this);
		},
		intersects : function(point) {
			return this.shape.intersects(point);
		},
		/**
		 * @param {PolygonAnchor}
		 *            anchor
		 */
		updateControlLine : function(anchor) {
			if (anchor) {
				if (anchor.prev) {
					var points = [];
					points.push(anchor.prev.getPosition());
					points.push(anchor.getPosition());
					if (anchor.next)
						points.push(anchor.next.getPosition());

					this.controlLine.setPoints(points);
					this.controlLine.show();
				}
			} else {
				this.controlLine.hide();
				this.updateShape();
			}
		},
		updateShape : function() {
			var coordinates = this.getCoordinates();
			if (coordinates.length > 0)
				this.shape.setPoints(coordinates);
		}
	};
	Kinetic.Util.extend(Polygon, Kinetic.Group);

	Polygon.MODE_SHOW = "show";
	Polygon.MODE_EDIT = "edit";

});