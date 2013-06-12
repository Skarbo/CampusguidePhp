$(function() {

	// Kinetic must exist
	if (typeof Kinetic === "undefined")
		return console.warn("Kinetic is not loaded");

	// ... ANCHOR

	TreeAnchor = function(config, tree) {
		config = config || {};
		tree = tree || null;
		Kinetic.Circle.call(this, $.extend(true, {
			name : "tree_anchor",
			x : 0,
			y : 0,
			radius : 8,
			fill : 'red',
			stroke : 'black',
			strokeWidth : 2,
			visible : false,
			draggable : false
		}, tree.setup['anchor'], config));
		this.tree = tree;
		this.nodeId = null;
		this.deleted = false;

		this.selected = false;

		this.setDraggable(this.tree.setup.mode == Tree.MODE_EDIT);
		// if (this.tree.setup.mode == Tree.MODE_EDIT)
		// this.show();

		// ON

		this.on("mouseover." + TreeAnchor.NAMESPACE, function() {
			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				$(this.tree.getStage().content).css("cursor", "pointer");
			}
		});
		this.on("mouseout." + TreeAnchor.NAMESPACE, function() {
			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				$(this.tree.getStage().content).css("cursor", "default");
			}
		});

		this.on("dragend." + TreeAnchor.NAMESPACE, function(event) {
			event.cancelBubble = true;
			this.moveToTop();

			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				if (!this.tree.isCreating) {
					var anchorClose = this.tree.getAnchorClose(this);
					if (anchorClose) {
						this.tree.mergeAnchor(this, anchorClose);
						this.tree.getLayer().draw();
					}

					this.getStage().fire("change", {
						node : this,
						type : "moved",
						pointer : this.getStage().getPointerPosition()
					});
				}
			}

			this.tree.changed = true;
		});

		this.on("dblclick." + TreeAnchor.NAMESPACE, function(event) {
			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				if (!this.tree.isCreating) {
					this.tree.createTree(null, this);
					this.tree.getLayer().draw();
				}
			}
		});
		this.on("click." + TreeAnchor.NAMESPACE, function(event) {
			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				if (!this.tree.isCreating) {
					if (event.which == 1) {
						// this.select();
						// this.tree.getLayer().draw();
						this.getStage().fire("select", {
							'node' : this,
							'type' : 'tree_anchor'
						});
					} else if (event.which == 3 && this.selected) {
						this.tree.removeAnchor(this);
						this.tree.getLayer().draw();
						this.tree.getStage().fire("change", {
							node : this,
							type : "deleted"
						});
					}
				}
			}
		});

		// /ON

	};
	TreeAnchor.prototype = {
		select : function() {
			if (!this.selected) {
				this.setStrokeWidth(4);
			}
			this.selected = true;
		},
		deselect : function() {
			if (this.selected) {
				this.setStrokeWidth(2);
			}
			this.selected = false;
		},
		toData : function() {
			var data = {
				x : Core.roundNumber(this.attrs.x),
				y : Core.roundNumber(this.attrs.y),
				id : this._id,
				nodeId : this.nodeId,
				deleted : this.deleted
			};

			return data;
		},
		fromData : function(data) {
			if (!data)
				return console.error("TreeAnchor.fromData: Data is null", data);
			this.setPosition(data.coordinate.x, data.coordinate.y);
			if (data.id)
				this.nodeId = data.id;
			this.updateSetup();
		},
		updateSetup : function() {
			this.setAttrs(this.tree.setup["anchor"]);
			this.setDraggable(this.tree.setup.mode == Tree.MODE_EDIT);
		}
	};

	Kinetic.Util.extend(TreeAnchor, Kinetic.Circle);

	TreeAnchor.NAMESPACE = "treeline";

	// ... /ANCHOR

	// ... LINE

	TreeLine = function(config, tree, anchor, anchorSibling) {
		config = config || {};
		Kinetic.Line.call(this, $.extend(true, {
			name : "tree_line",
			points : [ 0, 0, 0, 0 ],
			stroke : 'blue',
			strokeWidth : 4,
			lineCap : 'round',
			lineJoin : 'round',
			visible : true
		}, tree.setup['line'], config));
		this.selected = false;
		this.tree = tree;
		this.anchor = anchor;
		this.anchorSibling = anchorSibling;

		this.setDrawFunc(function(canvas) {
			var context = canvas.getContext();
			context.beginPath();

			if (this.anchor != null && this.anchorSibling != null) {
				context.moveTo(this.anchor.attrs.x, this.anchor.attrs.y);
				context.lineTo(this.anchorSibling.attrs.x, this.anchorSibling.attrs.y);
			}

			canvas.stroke(this);
		});

		// ON

		this.on("mouseover." + TreeLine.NAMESPACE, function() {
			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				$(this.tree.getStage().content).css("cursor", "pointer");
			}
		});
		this.on("mouseout." + TreeLine.NAMESPACE, function() {
			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				$(this.tree.getStage().content).css("cursor", "default");
			}
		});

		this.on("mouseup." + TreeLine.NAMESPACE, function(event) {
			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				if (event.which == 1) {
					this.getStage().fire("select", {
						'node' : this,
						"type" : "tree_line"
					});
				} else if (event.which == 3 && this.selected) {
					this.tree.removeRelationship(this.anchor, this.anchorSibling._id);
					this.tree.getLayer().draw();
				}
			}
		});
		this.on("dblclick." + TreeLine.NAMESPACE, function(event) {
			if (this.tree.setup.mode == Tree.MODE_EDIT) {
				if (this.selected) {
					this.tree.splitLine(this, KineticjsUtil.getPointerRelativePosition(this.getStage()));
					this.tree.getLayer().draw();
				}
			}
		});

		// /ON

	};
	TreeLine.prototype = {
		/**
		 * Select
		 */
		select : function() {
			if (!this.selected) {
				if (this.attrs.strokeSelected) {
					this.strokeOld = this.getStroke();
					this.setStroke(this.attrs.strokeSelected);
				} else {
					this.strokeOld = this.getStrokeWidth();
					this.setStrokeWidth(this.strokeOld + 2);
					// this.setDashArray([10, 5]);
				}
			}
			this.selected = true;
		},
		/**
		 * Delsect
		 */
		deselect : function() {
			if (this.selected) {
				if (this.attrs.strokeSelected) {
					this.setStroke(this.strokeOld);
				} else {
					this.setStrokeWidth(this.strokeOld || 2);
					// this.setDashArray([1, 1]);
				}
			}
			this.selected = false;
		},
		/**
		 * Update setup
		 */
		updateSetup : function() {
			this.setAttrs(this.tree.setup["line"]);
		}
	};

	Kinetic.Util.extend(TreeLine, Kinetic.Line);

	TreeLine.NAMESPACE = "treeline";

	// ... /LINE

	// ... TREE

	Tree = function(config, setup) {
		config = config || {};
		setup = $.extend(true, {}, {
			'mode' : Tree.MODE_SHOW
		}, setup);

		Kinetic.Group.call(this, $.extend(true, {
			name : "tree"
		}, setup['attrs'], config));

		this.setup = setup;
		this.anchorDraw = null;
		this.isCreating = false;
		this.selectable = false;
		this.changed = false;

		this.anchors = new Kinetic.Group({
			name : "tree_anchors"
		});
		this.lines = new Kinetic.Group({
			name : "tree_anchors_lines"
		});

		this.anchorsTable = {};
		this.relationshipTable = {};
		this.linesTable = {};

		this.add(this.lines);
		this.add(this.anchors);
		this.anchors.moveToTop();
	};

	Tree.prototype = {

		// ... ANCHOR

		/**
		 * Add anchor
		 * 
		 * @param {TreeAnchor}
		 *            anchor
		 * @param {TreeAnchor}
		 *            anchorSibling
		 */
		addAnchor : function(anchor, anchorSibling) {
			this.anchors.add(anchor);
			var id = anchor._id;
			this.anchorsTable[id] = anchor;
			this.relationshipTable[id] = [];

			if (anchorSibling) {
				this.addRelationship(anchor, anchorSibling);
			}
		},
		/**
		 * Remove anchor
		 * 
		 * @param {TreeAnchor}
		 *            mixed
		 */
		removeAnchor : function(anchor) {

			// Remove relationship
			// var relationship = this.relationshipTable[anchor._id];
			// if (this.relationshipTable[anchor._id]) {
			// while (this.relationshipTable[anchor._id].length > 0) {
			// this.removeRelationship(anchor,
			// this.relationshipTable[anchor._id][0]);
			// }
			// }
			var relationship = this.getRelationship(anchor);
			for ( var i = 0; i < relationship.length; i++)
				this.removeRelationship(anchor, relationship[i]);
			delete this.relationshipTable[anchor._id];

			// Delete anchor
			anchor.off("." + TreeAnchor.NAMESPACE);
			anchor.destroy();
			if (anchor.nodeId)
				anchor.deleted = true;
			else
				delete this.anchorsTable[anchor._id];
			$(this.getStage().content).css("cursor", "default");
		},

		/**
		 * @param {TreeAnchor}
		 *            anchor
		 * @param {TreeAnchor}
		 *            anchorMerge
		 */
		mergeAnchor : function(anchor, anchorMerge) {
			if (anchor == null || anchorMerge == null)
				return console.error("MergeAnchorClose: Anchor or anchor merge is null", anchor, anchorMerge);

			var relationship = this.getRelationship(anchorMerge);
			// console.log("MergeAnchor", anchor, anchorMerge, relationship);
			// Add anchor merge siblings to anchor
			// var relationshipSibling = $.merge([],
			// this.relationshipTable[anchorMerge._id];
			// for (var id in relationshipSibling)
			// this.addRelationship(anchor,
			// this.anchorsTable[relationshipSibling[id]]);
			for ( var i in relationship)
				this.addRelationship(anchor, this.anchorsTable[relationship[i]]);

			// Remove anchor merge
			this.removeAnchor(anchorMerge);
		},

		// ... /ANCHOR

		// ... RELATIONSHIP

		/**
		 * Add relationship
		 * 
		 * @param {TreeAnchor}
		 *            anchor
		 * @param {TreeAnchor}
		 *            anchorSibling
		 */
		addRelationship : function(anchor, anchorSibling) {
			if (anchor == null || anchorSibling == null)
				return console.error("AddRelationship: Anchor or sibling anchor is null", anchor, anchorSibling);
			if (anchor._id == anchorSibling._id)
				return console.error("AddRelationship: Anchor and sibling anchor is equal", anchor, anchorSibling);

			if (this.relationshipTable[anchor._id].indexOf(anchorSibling._id) < 0 && this.relationshipTable[anchorSibling._id].indexOf(anchor._id) < 0)
				this.relationshipTable[anchor._id].push(anchorSibling._id);
			// if () this.relationshipTable[anchorSibling._id].push(anchor._id);

			this.addLine(anchor, anchorSibling);
		},
		/**
		 * Remove relationship
		 * 
		 * @param {TreeAnchor}
		 *            anchor
		 * @param {Number}
		 *            anchorSiblingId
		 */
		removeRelationship : function(anchor, anchorSiblingId) {
			if (anchor == null)
				return console.error("RemoveRelationship: Anchor is null", anchor, anchorSiblingId);
			if (anchor._id == anchorSiblingId)
				return console.error("RemoveRelationship: Anchor and sibling anchor is equal", anchor, anchorSiblingId);

			if (this.relationshipTable[anchor._id]) {
				var indexOf = this.relationshipTable[anchor._id].indexOf(anchorSiblingId);
				if (indexOf > -1)
					this.relationshipTable[anchor._id].splice(indexOf, 1);
			}

			if (this.relationshipTable[anchorSiblingId]) {
				var indexOf = this.relationshipTable[anchorSiblingId].indexOf(anchor._id);
				if (indexOf > -1)
					this.relationshipTable[anchorSiblingId].splice(indexOf, 1);
			}

			this.removeLine(anchor, anchorSiblingId);
		},

		getRelationship : function(anchor) {
			var relationship = $.merge([], this.relationshipTable[anchor._id]);

			for ( var id in this.relationshipTable) {
				if (this.relationshipTable[id].indexOf(anchor._id) > -1)
					relationship.push(id);
			}

			return relationship;
		},

		// ... /RELATIONSHIP

		// ... LINE

		/**
		 * @param {TreeAnchor}
		 *            anchor
		 * @param {TreeAnchor}
		 *            anchorSibling
		 */
		addLine : function(anchor, anchorSibling) {
			if (anchor == null || anchorSibling == null)
				return console.error("AddLine: Anchor or sibling anchor is null", anchor, anchorSibling);
			if (anchor._id == anchorSibling._id)
				return console.error("AddLine: Anchor and sibling anchor is equal", anchor, anchorSibling);

			var id = anchor._id < anchorSibling._id ? anchor._id + "_" + anchorSibling._id : anchorSibling._id + "_" + anchor._id;
			if (!this.linesTable[id]) {
				var line = new TreeLine({}, this, anchor, anchorSibling);
				this.lines.add(line);
				this.linesTable[id] = line;
			}
		},
		/**
		 * @param {TreeAnchor}
		 *            anchor
		 * @param {Number}
		 *            anchorSiblingId
		 */
		removeLine : function(anchor, anchorSiblingId) {
			if (anchor == null)
				return console.error("RemoveLine: Anchor is null", anchor, anchorSiblingId);
			if (anchor._id == anchorSiblingId)
				return console.error("RemoveLine: Anchor and sibling anchor is equal", anchor, anchorSiblingId);
			var id = anchor._id < anchorSiblingId ? anchor._id + "_" + anchorSiblingId : anchorSiblingId + "_" + anchor._id;

			if (this.linesTable[id] != null) {
				this.linesTable[id].off("." + TreeLine.NAMESPACE);
				this.linesTable[id].destroy();
				// this.lines.remove(this.linesTable[id]);
				delete this.linesTable[id];
			}
			$(this.getStage().content).css("cursor", "default");
		},
		/**
		 * Split line between point
		 * 
		 * @param {TreeLine}
		 *            line
		 * @param {Object}
		 *            position
		 */
		splitLine : function(line, position) {
			if (line == null || position == null)
				return console.error("SplitLine: Line or position is null", line, anchor);

			var lineAnchor = line.anchor;
			var lineAnchorSibling = line.anchorSibling;
			this.removeRelationship(line.anchor, line.anchorSibling._id);

			var anchor = this.createAnchor({
				x : position.x,
				y : position.y
			});

			this.addAnchor(anchor, lineAnchor);
			this.addRelationship(anchor, lineAnchorSibling);
		},

		// ... /LINE

		getAnchorClose : function(anchor, distance) {
			if (anchor == null)
				return console.error("GetAnchorClose: Anchor is null", anchor);
			distance = distance || 10;

			var relationship = this.relationshipTable[anchor._id] || [];
			var anchorTemp = null;
			for ( var id in this.anchorsTable) {
				anchorTemp = this.anchorsTable[id];

				if (id != anchor._id && relationship.indexOf(id) < 0) {
					if (Math.abs(anchor.attrs.x - anchorTemp.attrs.x) <= distance && Math.abs(anchor.attrs.y - anchorTemp.attrs.y) <= distance)
						return anchorTemp;
				}
			}

			return null;
		},
		getCoordinates : function() {
			var coordinates = [];
			for ( var i in this.anchorsTable) {
				coordinates.push([ this.anchorsTable[i].attrs.x, this.anchorsTable[i].attrs.y ]);
			}
			return coordinates;
		},
		getAnchor : function(nodeId) {
			for ( var i in this.anchorsTable) {
				if (this.anchorsTable[i].nodeId == nodeId)
					return this.anchorsTable[i];
			}
			return null;
		},
		createTree : function(event, anchorSibling) {
			var namespace = "mousemove.draw_tree mouseup.draw_tree";
			var positionRelative = KineticjsUtil.getPointerRelativePosition(this.getStage());
			var position = positionRelative ? positionRelative : {
				x : 0,
				y : 0
			};

			// New anchor
			if (!event) {
				var context = this;
				this.isCreating = true;

				// Create anchor
				this.anchorDraw = this.createAnchor(position);

				if (anchorSibling) {
					this.addAnchor(this.anchorDraw, anchorSibling);
				} else {
					this.addAnchor(this.anchorDraw);
				}

				// Bind events
				this.getLayer().off(namespace);
				this.getLayer().on(namespace, function(event) {
					context.createTree(event, anchorSibling);
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
					// this.anchorDraw.setX(position.x);
					// this.anchorDraw.setY(position.y);

					// this.getLayer().draw();
				}
				// Place anchor
				else if (event.type == "mouseup") {
					if (this.getStage().isDragging())
						return;

					this.anchorDraw.stopDrag();

					// Cancel placing
					if (event.which == 3) {
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
						this.getLayer().draw();
						this.changed = true;
						return;
					}

					// Create anchor
					anchorSibling = this.anchorDraw;
					this.anchorDraw = this.createAnchor(position);
					if (anchorSibling) {
						this.addAnchor(this.anchorDraw, anchorSibling);
					} else {
						this.addAnchor(this.anchorDraw);
					}
					this.anchorDraw.startDrag();
				}
			}
		},
		bind : function() {
			if (!this.getStage())
				return console.error("Bind: Stage is null");
			var context = this;

			// SELECTABLE

			// Selectable
			this.getStage().on("selectable", function(event) {
				if (!context.isVisible())
					return;

				if (context.setup.mode == Tree.MODE_EDIT) {
					if (event.selectable) {
						context.selectable = true;
					} else {
						context.selectable = false;
					}
				}
			});

			// ... SELECT
			this.on("mouseup", function(event) {
				if (this.selectable) {
					this.getStage().fire("select", {
						"element" : this,
						"type" : "tree"
					});
				}
			});

			this.getStage().on("select", function(event) {
				if (!context.isVisible())
					return;

				if (context.setup.mode == Tree.MODE_EDIT) {
					// Anchor
					for ( var id in context.anchorsTable) {
						if ((event.node.attrs.name == "tree_anchor" && id == event.node._id) || (event.node.attrs.name == "tree")) {
							context.anchorsTable[id].select();
						} else
							context.anchorsTable[id].deselect();
					}
					// Line
					for ( var id in context.linesTable) {
						if ((event.node.attrs.name == "tree_line" && context.linesTable[id]._id == event.node._id)) {
							context.linesTable[id].select();
						} else
							context.linesTable[id].deselect();
					}
					context.getLayer().draw();
				}
			});

			// ... /SELECT

			// Deselect
			this.getStage().on("deselect", function(event) {
				if (!context.isVisible())
					return;

				if (context.setup.mode == Tree.MODE_EDIT) {
					// Anchor
					for ( var id in context.anchorsTable) {
						context.anchorsTable[id].deselect();
					}
					// Line
					for ( var id in context.linesTable) {
						context.linesTable[id].deselect();
					}
					context.getLayer().draw();
				}
			});

			// /SELECTABLE

			// Setup
			this.getLayer().on("setup", function(event) {
				if (event.type == "tree") {
					context.updateSetup(event.setup);
				}
			});

		},
		toData : function() {
			var data = {
				anchors : {},
				relationship : []
			};

			for ( var id in this.anchorsTable)
				data.anchors[id] = this.anchorsTable[id].toData();
			data.relationship = this.relationshipTable;

			data.changed = this.changed;

			return data;
		},
		fromData : function(data) {
			if (!data)
				return console.error("fromData: Data is null", data);
			var anchorsTemp = {};
			for ( var i in data.anchors) {
				var anchor = this.createAnchor({});
				this.addAnchor(anchor);
				anchor.fromData(data.anchors[i]);
				anchorsTemp[anchor.nodeId] = anchor;
			}
			for ( var nodeId in data.relationship) {
				for ( var i in data.relationship[nodeId]) {
					if (anchorsTemp[nodeId] && anchorsTemp[data.relationship[nodeId][i]])
						this.addRelationship(anchorsTemp[nodeId], anchorsTemp[data.relationship[nodeId][i]]);
				}
			}

			this.getLayer().draw();
		},
		updateSetup : function(setup) {
			this.setup = $.extend(true, {}, this.setup, setup);

			// Anchor
			this.anchors.getChildren().each(function(shape, n){
				shape.updateSetup();
			});
//			for ( var i in this.anchors.getChildren()) {
//				console.log("UpdateSetup.Anchor", this.anchors.getChildren()[i]);
//				if (typeof this.anchors.getChildren()[i] == "object")
//					this.anchors.getChildren()[i].updateSetup();
//			}
			// Line
			this.lines.getChildren().each(function(shape){
				shape.updateSetup();				
			});
//			for ( var i in this.lines.getChildren()) {
//				if (typeof this.lines.getChildren()[i] == "object")
//					this.lines.getChildren()[i].updateSetup();
//			}

			this.getLayer().draw();
		},
		createAnchor : function(config) {
			return new TreeAnchor(config, this);
		}
	};
	Kinetic.Util.extend(Tree, Kinetic.Group);

	// ... /TREE

	Tree.MODE_SHOW = "show";
	Tree.MODE_EDIT = "edit";

	// /TREE

});