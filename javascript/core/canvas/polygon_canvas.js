/**
 * Kinetic Polygon extention
 */

var Polygon, PolygonShape, PolygonAnchor, PolygonAnchorControl, PolygonAnchorPoint, PolygonAnchorHandle;
$(function() {

	// Kinetic must exist
	if (typeof Kinetic === "undefined")
		return;

	PolygonAnchorHandle = Kinetic.Circle.extend({
		init : function(config, polygon) {
			config = config || {};
			polygon = polygon || null;
			this._super($.extend({
				name : "anchor_handle",
				x : 0,
				y : 0,
				radius : 8,
				stroke : "#AAA",
				strokeWidth : 2,
				draggable : false,
				visible : false
			}, config));
			this.polygon = polygon;
			this.positionPrev = {};

			this.setDraggable(this.polygon.mode == Polygon.MODE_EDIT);
			if (this.polygon.mode == Polygon.MODE_EDIT)
				this.show();

			this.on("dragstart", function(event) {
				this.positionPrev = this.getPosition();
				this.moveToTop();
			});
			this.on("dragend", function(event) {
				if (this.polygon.mode == Polygon.MODE_EDIT) {
					event.cancelBubble = true;
					this.polygon.context.getEventHandler().handle(new AddHistoryEvent({
						type : "selected_drag",
						element : this
					}));
					this.moveToTop();
				}
			});
			this.on("mouseover", function() {
				if (this.polygon.mode == Polygon.MODE_EDIT) {
					$("body").css("cursor", "pointer");
					this.setStrokeWidth(4);
					this.getLayer().draw();
				}
			});
			this.on("mouseout", function() {
				if (this.polygon.mode == Polygon.MODE_EDIT) {
					$("body").css("cursor", "default");
					this.setStrokeWidth(2);
					this.getLayer().draw();
				}
			});
		},
		undoMove : function() {
			if (this.positionPrev) {
				this.setPosition(this.positionPrev);
				this.getLayer().draw();
			}
		}
	});

	PolygonAnchorControl = Kinetic.Group.extend({
		init : function(config, anchor) {
			config = config || {};
			this._super($.extend({
				name : "anchor_control",
				visible : false
			}, config));
			this.anchor = anchor;

			this.handleFirst = new PolygonAnchorHandle({}, this.anchor.polygon);
			this.handleSecond = new PolygonAnchorHandle({}, this.anchor.polygon);
			this.line = new Kinetic.Line({
				name : "control_line",
				dashArray : [ 10, 10, 0, 10 ],
				strokeWidth : 3,
				stroke : "black",
				lineCap : "round",
				opacity : 0.3,
				points : [ this.anchor.attrs.x, this.anchor.attrs.y ],
				listening : false
			});
			this.line.control = this;

			this.line.setDrawFunc(function(context) {
				context.beginPath();

				if (this.control.anchor.prev && this.control.anchor.type != Polygon.LINE_TYPE_LINE) {
					context.moveTo(this.control.anchor.prev.attrs.x, this.control.anchor.prev.attrs.y);

					switch (this.control.anchor.type) {
					case Polygon.LINE_TYPE_QUAD:
						context.lineTo(this.control.handleFirst.attrs.x, this.control.handleFirst.attrs.y);
						break;

					case Polygon.LINE_TYPE_BEZIER:
						context.lineTo(this.control.handleFirst.attrs.x, this.control.handleFirst.attrs.y);
						context.lineTo(this.control.handleSecond.attrs.x, this.control.handleSecond.attrs.y);
						break;
					}

					context.lineTo(this.control.anchor.attrs.x, this.control.anchor.attrs.y);
				}

				context.lineCap = "round";
				this.stroke(context);
			});

			this.isPositioned = false;

			this.add(this.handleFirst);
			this.add(this.handleSecond);
			this.add(this.line);
		},
		select : function() {
			if (!this.anchor.prev)
				return this.hide();

			if (!this.isPositioned)
				this.positionControl();

			switch (this.anchor.type) {
			case Polygon.LINE_TYPE_QUAD:
				this.show();
				this.handleFirst.show();
				this.handleSecond.hide();
				this.line.show();
				this.moveToTop();
				break;

			case Polygon.LINE_TYPE_BEZIER:
				this.show();
				this.handleFirst.show();
				this.handleSecond.show();
				this.line.show();
				this.moveToTop();
				break;

			default:
				this.hide();
				break;
			}
		},
		deselect : function() {
			this.hide();
		},
		positionControl : function() {
			if (!this.anchor.prev)
				return;

			var coor = {
				x : (this.anchor.attrs.x + this.anchor.prev.attrs.x) / 2,
				y : (this.anchor.attrs.y + this.anchor.prev.attrs.y) / 2
			};
			this.handleFirst.setX((this.anchor.prev.attrs.x + coor.x) / 2);
			this.handleFirst.setY((this.anchor.prev.attrs.y + coor.y) / 2);
			this.handleSecond.setX((this.anchor.attrs.x + coor.x) / 2);
			this.handleSecond.setY((this.anchor.attrs.y + coor.y) / 2);

			this.line.setPoints([ this.anchor.attrs.x, this.anchor.attrs.y, this.handleFirst.attrs.x, this.handleFirst.attrs.y, this.handleSecond.attrs.x,
					this.handleSecond.attrs.y, this.anchor.prev.attrs.x, this.anchor.prev.attrs.y ]);

			this.isPositioned = true;
		},
		removeControl : function() {
			this.getParent().remove(this);
		},
		toData : function() {
			var data = [];

			switch (this.anchor.type) {
			case Polygon.LINE_TYPE_QUAD:
				data.push(Core.roundNumber(this.anchor.control.handleFirst.attrs.x + this.anchor.polygon.attrs.x));
				data.push(Core.roundNumber(this.anchor.control.handleFirst.attrs.y + this.anchor.polygon.attrs.y));
				break;
			case Polygon.LINE_TYPE_BEZIER:
				data.push(Core.roundNumber(this.anchor.control.handleFirst.attrs.x + this.anchor.polygon.attrs.x));
				data.push(Core.roundNumber(this.anchor.control.handleFirst.attrs.y + this.anchor.polygon.attrs.y));
				data.push(Core.roundNumber(this.anchor.control.handleSecond.attrs.x + this.anchor.polygon.attrs.x));
				data.push(Core.roundNumber(this.anchor.control.handleSecond.attrs.y + this.anchor.polygon.attrs.y));
				break;
			}

			return data.join("%");
		},
		fromData : function(data) {
			data = data || "";
			var dataArray = jQuery.isArray( data ) ? data : data.split("%");

			this.positionControl();

			switch (this.anchor.type) {
			case Polygon.LINE_TYPE_QUAD:
				this.handleFirst.setX(parseFloat(dataArray[0]));
				this.handleFirst.setY(parseFloat(dataArray[1]));
				break;

			case Polygon.LINE_TYPE_BEZIER:
				this.handleFirst.setX(parseFloat(dataArray[0]));
				this.handleFirst.setY(parseFloat(dataArray[1]));
				this.handleSecond.setX(parseFloat(dataArray[2]));
				this.handleSecond.setY(parseFloat(dataArray[3]));
				break;

			default:
				this.type = Polygon.LINE_TYPE_STRAIGHT;
				break;
			}
		}
	});

	PolygonAnchor = PolygonAnchorHandle.extend({
		init : function(config, polygon) {
			config = config || {};
			polygon = polygon || null;
			this._super($.extend({
				name : "anchor",
				stroke : "#666"
			}, config), polygon);

			this.type = Polygon.LINE_TYPE_STRAIGHT;
			this.next = null;
			this.prev = null;
			this.control = null;
			this.isSelected = false;

			this.on("click", function(event) {
				if (this.polygon.mode == Polygon.MODE_EDIT) {
					event.cancelBubble = true;
					if (!this.polygon.isCreating) {
						if (event.which == 1)
							this.polygon.context.getEventHandler().handle(new SelectEvent("polygon_anchor", this));
						else if (event.which == 3 && this.isSelected) {
							this.polygon.context.getEventHandler().handle(new SelectEvent());
							this.polygon.removeAnchor(this);
						}
					}
				}
			});
			this.on("dblclick", function(event) {
				if (this.polygon.mode == Polygon.MODE_EDIT) {
					event.cancelBubble = true;
					if (!this.polygon.isCreating) {
						if (event.which == 1)
							this.polygon.createPolygon(null, this);
					}
				}
			});
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
			if (this.control)
				this.control.removeControl();
			this.getParent().remove(this);
		},
		select : function(secondary) {
			this.setStroke("#FF0000");
			this.control.select();
			this.isSelected = true;
		},
		deselect : function() {
			this.setStroke("#666");
			this.control.deselect();
			this.isSelected = false;
		},
		erase : function() {
			this.polygon.removeAnchor(this);
		},
		undo : function() {
			this.polygon.addAnchorAfter(this, this.prev);
			this.getLayer().draw();
		},
		toData : function() {
			var data = [];

			data.push(Core.roundNumber(this.attrs.x + this.polygon.attrs.x));
			data.push(Core.roundNumber(this.attrs.y + this.polygon.attrs.y));

			switch (this.type) {
			case Polygon.LINE_TYPE_QUAD:
				data.push("Q");
				break;
			case Polygon.LINE_TYPE_BEZIER:
				data.push("B");
				break;

			default:
				data.push("L");
				break;
			}

			data.push(this.control.toData());

			return data.join(",");
		},
		fromData : function(data) {
			data = data || "";
			var dataArray = jQuery.isArray( data ) ? data : data.split(",");

			this.setX(parseFloat(dataArray[0]));
			this.setY(parseFloat(dataArray[1]));

			switch (dataArray[2]) {
			case "Q":
				this.type = Polygon.LINE_TYPE_QUAD;
				break;

			case "B":
				this.type = Polygon.LINE_TYPE_BEZIER;
				break;

			default:
				this.type = Polygon.LINE_TYPE_STRAIGHT;
				break;
			}

			this.control.fromData(dataArray.length >= 3 ? dataArray[3] : "");
		},
		getCoordinates : function() {
			var coordinates = [];

			coordinates.push([ this.attrs.x, this.attrs.y ]);

			switch (this.type) {
			case Polygon.LINE_TYPE_QUAD:
				coordinates.push([ this.control.handleFirst.attrs.x, this.control.handleFirst.attrs.y ]);
				break;

			case Polygon.LINE_TYPE_BEZIER:
				coordinates.push([ this.control.handleFirst.attrs.x, this.control.handleFirst.attrs.y ]);
				coordinates.push([ this.control.handleSecond.attrs.x, this.control.handleSecond.attrs.y ]);
				break;
			}
			return coordinates;
		}
	});

	PolygonShape = Kinetic.Shape.extend({
		init : function(config, polygon) {
			config = config || {};
			this._super($.extend({
				name : "shape",
				stroke : "red",
				strokeWidth : 4,
				lineJoin : "round",
				fill : "#999",
				opacity : 0.7
			}, config));

			this.polygon = polygon;

			this.setDrawFunc(function(context) {
				var shape = this;
				context.beginPath();

				if (this.polygon.anchorFirst) {
					context.moveTo(this.polygon.anchorFirst.attrs.x, this.polygon.anchorFirst.attrs.y);

					this.polygon.eachAnchor(function(anchor) {
						shape.drawLineFunc(context, anchor);
					});

					this.drawLineFunc(context, this.polygon.anchorFirst);
				}

				// context.closePath();
				context.lineCap = "round";
				this.fill(context);
				this.stroke(context);
			});
			this.drawLineFunc = function(context, anchor) {
				switch (anchor.type) {
				case Polygon.LINE_TYPE_QUAD:
					context.quadraticCurveTo(anchor.control.handleFirst.attrs.x, anchor.control.handleFirst.attrs.y, anchor.attrs.x, anchor.attrs.y);
					break;

				case Polygon.LINE_TYPE_BEZIER:
					context.bezierCurveTo(anchor.control.handleFirst.attrs.x, anchor.control.handleFirst.attrs.y, anchor.control.handleSecond.attrs.x,
							anchor.control.handleSecond.attrs.y, anchor.attrs.x, anchor.attrs.y);
					break;

				default:
					context.lineTo(anchor.attrs.x, anchor.attrs.y);
					break;
				}
			};

			this.on("click", function(event) {
				if (this.polygon.mode == Polygon.MODE_EDIT) {
					event.cancelBubble = true;
					if (!this.polygon.isCreating) {
						if (event.which == 1)
							this.polygon.context.getEventHandler().handle(new SelectEvent("polygon", this.polygon));
						else if (event.which == 3 && this.isSelected)
							this.polygon.context.getEventHandler().handle(new DeleteEvent());
					}
				}
			});
			this.on("dblclick", function(event) {
				if (this.polygon.mode == Polygon.MODE_EDIT) {
					event.cancelBubble = true;
					if (!this.polygon.isCreating) {
						if (event.which == 1)
							this.polygon.createPolygon(null, this);
					}
				}
			});
		}
	});

	Polygon = Kinetic.Group.extend({
		init : function(config, context) {
			config = config || {};
			this._super($.extend({
				name : "polygon"
			}, config));
			this.context = context;

			this.isSelected = false;
			this.shape = new PolygonShape({}, this);

			this.anchors = new Kinetic.Group({
				name : "anchors"
			});
			this.controls = new Kinetic.Group({
				name : "controls"
			});
			this.text = new Kinetic.Text({
				name : "name",
				visible : false,
				text : "",
				textFill : '#000',
				fontSize : 20,
				listening : false
			});
			this.text.polygon = this;

			this.anchorFirst = null;
			this.anchorLast = null;
			this.anchorDraw = null;
			this.isCreating = false;
			this.deleted = false;
			this.object = {
				type : null,
				element : null
			};
			this.mode = Polygon.MODE_SHOW;

			this.add(this.shape);
			this.add(this.anchors);
			this.add(this.controls);
			this.add(this.text);

			this.on("click", function(event) {
				event.cancelBubble = true;
			});
			this.on("mouseover", function() {
				if (this.mode == Polygon.MODE_EDIT) {
					this.setDraggable(this.context.polygonsIsDraggable);
					if (this.context.polygonsIsDraggable && $("body").css("cursor") != "pointer")
						$("body").css("cursor", "pointer");
				}
			});
			this.on("mouseout", function() {
				if (this.mode == Polygon.MODE_EDIT) {
					this.setDraggable(false);
					if ($("body").css("cursor") != "default")
						$("body").css("cursor", "default");
				}
			});
			this.on("dragstart", function() {
				this.positionPrev = this.getPosition();
			});
			this.on("dragend", function() {
				if (this.mode == Polygon.MODE_EDIT) {
					this.context.getEventHandler().handle(new AddHistoryEvent({
						type : "selected_drag",
						element : this
					}));
				}
			});
		},
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

			anchor.control = new PolygonAnchorControl({}, anchor);
			this.controls.add(anchor.control);
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

			anchor.control = new PolygonAnchorControl({}, anchor);
			this.controls.add(anchor.control);
		},
		removeAnchor : function(anchor) {
			if (this.anchors.isAncestorOf(anchor)) {
				if (this.anchorFirst._id == anchor._id)
					this.anchorFirst = anchor.next;
				if (this.anchorLast._id == anchor._id)
					this.anchorLast = anchor.prev;
				anchor.removeAnchor();

				if (this.anchors.getChildren().length <= 1)
					this.deletePolygon();
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
			var positionUser = this.getStage().getUserPosition();
			var position = positionUser ? {
				x : ((positionUser.x - this.getStage().attrs.x) / this.getStage().attrs.scale.x) - this.attrs.x,
				y : ((positionUser.y - this.getStage().attrs.y) / this.getStage().attrs.scale.y) - this.attrs.y
			} : {
				x : 0,
				y : 0
			};

			// New anchor
			if (!event) {
				var context = this;
				this.isCreating = true;

				// Create anchor
				this.anchorDraw = new PolygonAnchor({
					x : position.x,
					y : position.y
				}, this);
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
			} else if (positionUser) {
				event.cancelBubble = true;

				// Move anchor
				if (event.type == "mousemove" && this.anchorDraw) {
					this.anchorDraw.show();
					this.anchorDraw.setX(position.x);
					this.anchorDraw.setY(position.y);

					this.getLayer().draw();
				}
				// Place anchor
				else if (event.type == "mouseup") {
					if (this.getStage().isDragging())
						return;

					// Cancel placing
					if (event.which == 3) {
						event.preventDefault();
						this.removeAnchor(this.anchorDraw);
						this.getLayer().off(namespace);
						this.anchorDraw = null;
						delete this.anchorDraw;
						this.isCreating = false;
						anchorResume = null;
						this.getLayer().draw();
						return;
					}

					// Create anchor
					anchorResume = this.anchorDraw;
					this.anchorDraw = new PolygonAnchor({
						x : position.x,
						y : position.y
					}, this);
					if (anchorResume) {
						this.addAnchorAfter(this.anchorDraw, anchorResume);
					} else {
						this.addAnchor(this.anchorDraw);
					}
				}
			}
		},
		toData : function() {
			var data = [];
			this.eachAnchor(function(anchor) {
				data.push(anchor.toData());
			});
			return data.join("|");
		},
		fromData : function(data) {
			data = data || "";
			var dataAnchor = jQuery.isArray( data ) ? data : data.split("|");
			var anchor;
			for (i in dataAnchor) {
				anchor = new PolygonAnchor({}, this);
				this.addAnchor(anchor);
				anchor.fromData(dataAnchor[i]);
			}
			this.drawText();
		},
		getCoordinates : function() {
			var coordinates = [];
			this.eachAnchor(function(anchor) {
				coordinates = coordinates.concat(anchor.getCoordinates());
			});
			return coordinates;
		},
		copy : function(context) {
			var data = this.toData();
			var polygon = new Polygon({}, context);
			polygon.fromData(data);
			return polygon;
		},
		select : function(secondary) {
			this.shape.setShadow({
				color : 'black',
				blur : 10,
				offset : [ 10, 10 ],
				alpha : 0.3
			});
			this.isSelected = true;
		},
		deselect : function() {
			this.shape.setShadow(null);
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
		drawText : function() {
			if (this.object.type != "element" || !this.object.element)
				return;

			if (this.anchors.length < 2)
				return;

			var coordinates = [];
			this.eachAnchor(function(anchor) {
				coordinates.push([ anchor.attrs.x, anchor.attrs.y ]);
			});
			// Find angle of first vector
			// var outerBounds = CanvasUtil.getOuterBounds(coordinates);

			// var angle = Math.atan2(this.anchorFirst.next.getY() -
			// this.anchorFirst.getY(), this.anchorFirst.next.getX() -
			// this.anchorFirst.getX());
			// var angle = Math.atan2(outerBounds[2][1] - outerBounds[1][1],
			// outerBounds[2][0] - outerBounds[1][0]);

			// Get element center
			var elementCenter = CanvasUtil.centerCoordinates(coordinates);

			var bounds = CanvasUtil.getMaxBounds(coordinates);

			this.text.setWidth(bounds[2] - bounds[0]);
			this.text.setHeight(bounds[3] - bounds[1]);

			this.text.setText(this.object.element.name);
			// this.text.setRotation(angle);
			// this.text.setX(elementLegendText.getX() -
			// (elementLegendText.getTextWidth() / 2));
			this.text.setX(elementCenter[0] - (this.text.getTextWidth() / 2));
			this.text.setY(elementCenter[1]);
			this.text.show(true);
		}
	});
	Polygon.LINE_TYPE_STRAIGHT = "straight";
	Polygon.LINE_TYPE_QUAD = "quad";
	Polygon.LINE_TYPE_BEZIER = "bezier";
	Polygon.MODE_SHOW = "show";
	Polygon.MODE_EDIT = "edit";

});