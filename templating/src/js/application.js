var uiClass= function(){

	var headerSource = $("#header-template").html();
	var headerTemplate = Handlebars.compile(headerSource);

	var slideSource = $("#slide-template").html();
	var slideTemplate = Handlebars.compile(slideSource);

	this.render = function(data){
		var headerRender = headerTemplate(data);
		var slidesRender = slideTemplate(data);
		$('.slides').html(slidesRender);
		$('.header').html(headerRender);

		console.log(data)
		$('.theme').text(data.book.theme.title)
	};
};

var main = new uiClass();

$.ajax({
  type: 'GET',
  url: book,
  dataType: 'json',
  timeout: 300,
  success: function(data){
  	main.render(data.data);
  },
  error: function(xhr, type){
    console.log('Ajax error!')
  }
})