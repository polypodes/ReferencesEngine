var canvasClass = function(){

    this.ctx=null;

    loadImages=function(sources, callback) {
        var images = {};
        var loadedImages = 0;
        var numImages = 0;
        for(var src in sources) {
            numImages++;
        }
        for(var src in sources) {
            images[src] = new Image();
            images[src].onload = function() {
                if(++loadedImages >= numImages) {
                  callback(images);
                }
            };
        images[src].src = sources[src];
        }
    }

    update = function(activeAnchor) {
        var group = activeAnchor.getParent();

        var topLeft = group.find('.topLeft')[0];
        var topRight = group.find('.topRight')[0];
        var bottomRight = group.find('.bottomRight')[0];
        var bottomLeft = group.find('.bottomLeft')[0];
        var image = group.find('.image')[0];

        var anchorX = activeAnchor.x();
        var anchorY = activeAnchor.y();

        // update anchor positions
        switch (activeAnchor.name()) {
            case 'topLeft':
                topRight.y(anchorY);
                bottomLeft.x(anchorX);
            break;
            case 'topRight':
                topLeft.y(anchorY);
                bottomRight.x(anchorX);
            break;
            case 'bottomRight':
                bottomLeft.y(anchorY);
                topRight.x(anchorX); 
            break;
            case 'bottomLeft':
                bottomRight.y(anchorY);
                topLeft.x(anchorX); 
            break;
        }

        image.setPosition(topLeft.getPosition());

        var width = topRight.x() - topLeft.x();
        var height = bottomLeft.y() - topLeft.y();

        if(width && height) {
            image.setSize({width:width, height: height});
        }
    }

    addAnchor = function(group, x, y, name) {
        var stage = group.getStage();
        var layer = group.getLayer();

        var anchor = new Kinetic.Circle({
            x: x,
            y: y,
            stroke: '#666',
            fill: '#ddd',
            strokeWidth: 2,
            radius: 8,
            name: name,
            draggable: true,
            dragOnTop: false
        });

        anchor.on('dragmove', function() {
            update(this);
            layer.draw();
        });

        anchor.on('mousedown touchstart', function() {
            group.setDraggable(false);
        });

        anchor.on('dragend', function() {
            group.setDraggable(true);
            layer.draw();
        });

        anchor.on('mouseover', function(e) {
            var layer = this.getLayer();
            document.body.style.cursor = 'pointer';
            this.setStrokeWidth(4);
            layer.draw();
        });

        anchor.on('mouseout', function() {
            var layer = this.getLayer();
            document.body.style.cursor = 'default';
            this.strokeWidth(2);
            layer.draw();
        });

        group.add(anchor);
    };

    var layer = null;
    var stage = null;
    var imageGroup = null;
    var titleGroup = null;
    var subTitleGroup = null;
    var bottomLineGroup = null;

    var ratio = 1.41428571;
    var content_w = 500;
    var content_h = 500*ratio;

    var img_ratio_wh = null;
    
    function insertImage(images){
        var img_w=images.cover.width;
        var img_h=images.cover.height;

        img_ratio_wh=img_w/img_h;

        var ratio_wh=img_w/img_h;
        var ratio_hw=img_h/img_w;

        if(img_w>content_w){
            img_w=content_w;
            img_h=img_w*ratio_hw;
        }
        if(img_h>content_h){
            img_h=content_h;
            img_w=img_h*ratio_wh;
        }

        var coverImg = new Kinetic.Image({
            x: 0,
            y: 0,
            image: images.cover,
            width: img_w,
            height: img_h,
            name: 'image'
        });

        imageGroup.add(coverImg);
        addAnchor(imageGroup, 0, 0, 'topLeft');
        addAnchor(imageGroup, img_w, 0, 'topRight');
        addAnchor(imageGroup, img_w, img_h, 'bottomRight');
        addAnchor(imageGroup, 0, img_h, 'bottomLeft');
    }

    this.initStage=function(images) {

        stage = new Kinetic.Stage({
            container: 'canvas',
            width: content_w,
            height: content_h
        });

        // Add white background
        var rect = new Kinetic.Rect({
            x: 0,
            y: 0,
            width: 500,
            height: 710,
            fill: '#FFFFFF'
        });

        // Image
        imageGroup = new Kinetic.Group({
            x: 0,
            y: 0,
            draggable: true
        });

        titleGroup = new Kinetic.Group({
            x: 10,
            y: 40,
            draggable: true
        });

        subTitleGroup = new Kinetic.Group({
            x: 10,
            y: 110,
            draggable: true
        });

        bottomLineGroup = new Kinetic.Group({
            x: 10,
            y: 650,
            draggable: true
        });
        
        layer = new Kinetic.Layer();
        layer.add(rect);

        layer.add(imageGroup);
        layer.add(titleGroup);
        layer.add(subTitleGroup);
        layer.add(bottomLineGroup);
        stage.add(layer);

        insertImage(images);
        stage.draw();

    }

    var text_pos = {
        x:20,
        y:20
    };

    this.addText=function(contentTitle,contentSubtitle,contentBottomLine){

        titleGroup.removeChildren();
        subTitleGroup.removeChildren();
        bottomLineGroup.removeChildren();

        var textTitleGroup = new Kinetic.Text({
            x: text_pos.x,
            y: text_pos.y,
            text: contentTitle.text,
            fontSize: contentTitle.fontsize,
            fontFamily: contentTitle.fontfamily,
            fill: contentTitle.color,
            fontStyle:"300"
        });

        var textSubTitle = new Kinetic.Text({
            x: text_pos.x,
            y: text_pos.y,
            text: contentSubtitle.text,
            fontSize: contentSubtitle.fontsize,
            fontFamily: contentSubtitle.fontfamily,
            fill: contentSubtitle.color,
            fontStyle:"300",
            lineHeight:1.5
        });

        var textBottomLine = new Kinetic.Text({
            x: text_pos.x,
            y: text_pos.y,
            text: contentBottomLine.text,
            fontSize: contentBottomLine.fontsize,
            fontFamily: contentBottomLine.fontfamily,
            fill: contentBottomLine.color,
            fontStyle:"300"
        });

        titleGroup.add(textTitleGroup);
        subTitleGroup.add(textSubTitle);
        bottomLineGroup.add(textBottomLine);

        layer.draw();
    }

    this.addImage=function(url){
        console.log('addimage');
        imageGroup.removeChildren();
        loadImages({cover:url},function(images){
            insertImage(images);
            layer.draw();
        })
    }

    this.exportCover=function(){
        stage.toDataURL({
            callback: function(dataUrl) {
                window.open(dataUrl);
            }
        });
    }

    this.sources={
        cover: 'src/images/sample.jpg'
    }

    var that = this;
    loadImages(this.sources,this.initStage);
}