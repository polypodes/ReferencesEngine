var utilsClass = function(){
    this.fixVScrollHeight=function(){
        var pos = $('aside .scrollable').offset();
        var h = $(document).height();
        $('aside .scrollable').css("height",h-pos.top+"px")
    }
    this.fixBottomBoxHeight=function(){
        var pos = $('.new_project_wysiwyg').height();
        var h = $(document).height();
        var fh = h-(pos+100);
        console.log(fh)
        $('.bottom_box').css("height",fh+"px")
    }
}