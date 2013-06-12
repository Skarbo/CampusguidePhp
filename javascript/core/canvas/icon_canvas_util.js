function IconCanvasUtil() {
}

IconCanvasUtil.location = function(config) {
	config = config || {};
	var group = new Kinetic.Group({
		scale : 0.5,
		draggable : true,
		opacity : 0.7
	});
	group.setAttrs(config['group']);
	var circle = new Kinetic.Circle({
		height : 25,
		width : 25,
		fill : "#4A86E8"
	});
	circle.setAttrs(config['circle']);
	var halo = new Kinetic.Circle({
		height : 40,
		width : 40,
		stroke : "#7E9598",
		strokeWidth : 2
	});
	halo.setAttrs(config['halo']);
	group.add(halo);
	group.add(circle);

	group.on("dragstart", function() {
		this.transitionTo({
			offset : {
				y : 20
			},
			duration : 0.1
		});
	});

	group.on("dragend", function() {
		this.transitionTo({
			offset : {
				y : 0,
				x : 0
			},
			duration : 0.1
		});
	});

	group.on("mouseover", function() {
		$(this.getStage().content).css("cursor", "pointer");
	});
	group.on("mouseout", function() {
		$(this.getStage().content).css("cursor", "default");
	});

	// halo.setPosition(halo.getWidth() / 2, halo.getHeight() / 2);
	// circle.setPosition(circle.getWidth() / 2, circle.getHeight() / 2);
	return group;
};