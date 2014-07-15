// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};

var utilsClass = function(){
    this.fixVScrollHeight=function(){
        var pos = $('aside .scrollable').offset();
        var h = $(document).height();
        $('aside .scrollable').css("height",h-pos.top+"px")
    }
}