// var selectMedia = '<option value="add_media" selected="selected">Add a media</option>';
var test ="<input type='text'>"

var collectionTagsHolder = $('ul.tags');
var $addTagLink = $('<a href="#" class="add_tag_link">Add tag</a>');
var $newLinkLiTag = $('<ul></ul>').append($addTagLink);


var collectionMediasHolder = $('ul.medias');
var $addMediaLink = $('<a href="#" class="add_media_link">Add Media</a>');
var $newLinkLiMedia = $('<ul></ul>').append($addMediaLink);


var collectionRendersHolder = $('ul.renders');
var $addRenderLink = $('<a href="#" class="add_render_link">Add Render</a>');
var $newLinkLiRender = $('<ul></ul>').append($addRenderLink);

function searchToArray(string){

  var k =0;
  string = $.trim(string);
  var result ="";
  var array_search = [];
  for (var i = 0; i<string.length ; i++) {
    if(string[i] == ','){
      array_search[k] = $.trim(result);
      result='';
      k++;
      i++;
    }
    result += string[i];
  };
  if (result != 'undefined') {
    array_search[k] = $.trim(result);
  };

  return array_search;
}
function addForm(collectionHolder, $newLinkLi) {
    var prototype = collectionHolder.attr('data-prototype');

    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    var $newFormLi = $('<li class="input"></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addFormDeleteLink($newFormLi);
    $($newFormLi).find('.providerSelector').change(function(){
        var valueSelected=$('option:selected', this).text();
        var input=$(this).parent().parent().children(':first-child').children('.providerInput');
        if (valueSelected == "Dailymotion" || valueSelected == "Youtube" || valueSelected == "Vimeo")
        {
          changeTypeInput(input, 'text');
        }
        if (valueSelected == "File" || valueSelected == "Image"){
          changeTypeInput(input, "file");
      }
    });
    $($newFormLi).find('.mediaSelector').change(function(){
      var valueSelected=$('option:selected', this).text();
      var input =$(this).parent().parent().find(".providerInput");
      var selector =$(this).parent().parent().find(".providerSelector");
      if(valueSelected == "Add media")
      {
        input.show();
        selector.show();
      }else{
        input.hide();
        selector.hide();
      }
    });
    $($newFormLi).find('.renderSelector').change(function(){
      var valueSelected=$('option:selected', this).text();
      var input =$(this).parent().parent().find(".providerInput");
      var selector =$(this).parent().parent().find(".providerSelector");
      if(valueSelected == "Add render")
      {
        input.show();
        selector.show();
      }else{
        input.hide();
        selector.hide();
      }
    });
        $( ".tagInput").autocomplete({
      source: availableTags,
      messages: {
        noResults: '',
        results: function() {}
    }
    });

}

function setProject(project_array, id)
{
  for (var i = 0; i < project_array.length; i++) {
    if(project_array[i]['project_id'] == id)
    {
      project_array[i]['project_select'] = true;
      // console.log('change to : '+project_array[i]['project_id']+'='+project_array[i]['project_select']);
    }
  };
  return project_array;
}

function unsetProject(project_array, id)
{
  for (var i = 0; i < project_array.length; i++) {
    if(project_array[i]['project_id'] == id)
    {
      project_array[i]['project_select'] = false;
      // console.log('change to : '+project_array[i]['project_id']+'='+project_array[i]['project_select']);
    }
  };
  return project_array;
}

function addFormDeleteLink($MediaFormLi)
{
    var $removeFormA = $('<a href="#"><span class="glyphicon glyphicon-remove"></span></a>');
    $MediaFormLi.append($removeFormA);
    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $MediaFormLi.remove();
    });
}

function changeTypeInput(input, type)
{
  var parent = input.parent();
  name = input.attr('name');
  id = input.attr('id');
  className = input.attr('class');
  newInput = parent.append('<input type="'+type+'" id="'+id+'" name="'+name+'" class="'+className+'"/>');
  input.remove();
}

$(document).ready(function () {
  // $('.providerInput').remove();
  var nbProject = $(".project").length;
  var projects = new Array(nbProject);
  for (var i = 0; i < nbProject; i++ ) {
      projects[i] = new Array(2);
  }




  var nbProjectSelected=0;
	$(".fancybox").fancybox({
		helpers: {
              title : {
                  type : 'hover'
              }
          }
      });
	$("#single_1").fancybox({
          helpers: {
              title : {
                  type : 'hover'
              }
          }
      });
	$('.btn-remove').on('click',function () {
		var self = $(this);
		var id = $(this).data('id');
		var title = $(this).data('title');
		noty({
			text        : 'Supprimer : "'+title+'" ?',
			type        : self.data('type'),
			dismissQueue: true,
			layout      : self.data('layout'),
			buttons     : [
				{addClass: 'btn btn-primary', text: 'Oui', onClick: function ($noty) {
					$noty.close();
					document.location.href='./remove/'+id;
				}
				},
				{addClass: 'btn btn-danger', text: 'Annuler', onClick: function ($noty) {
					$noty.close();
					noty({force: true, text: 'Le projet n\'a pas été supprimer.', type: 'error', layout: self.data('layout')});
				}
				}
			]
		});
		return false;
	});
	$( ".project-mouseover" )
  .on( "mouseenter", function() {
    	$(this).children(".project-btn").show();
    	$(this).children(".project-img").hide();
  })
  .on( "mouseleave", function() {
    	$(this).children(".project-btn").hide();
    	$(this).children(".project-img").show();
  });



	collectionTagsHolder.append($newLinkLiTag);
  $addTagLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionTagsHolder, $newLinkLiTag);
  });
  collectionTagsHolder.find('li.input').each(function() {
    addFormDeleteLink($(this));
  });


  collectionMediasHolder.append($newLinkLiMedia);
  $addMediaLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionMediasHolder, $newLinkLiMedia);
  });
  collectionMediasHolder.find('li').each(function() {
    addFormDeleteLink($(this));
  });
  collectionRendersHolder.append($newLinkLiRender);
  $addRenderLink.on('click', function(e) {
    e.preventDefault();
    addForm(collectionRendersHolder, $newLinkLiRender);
  });
  collectionRendersHolder.find('li').each(function() {
    addFormDeleteLink($(this));
  });

  $(".providerSelector").each(function(){
      $(this).change(function(){
        var valueSelected=$('option:selected', this).text();
        var input=$(this).parent().parent().children(':first-child').children('.providerInput');
        if (valueSelected == "Dailymotion" || valueSelected == "Youtube" || valueSelected == "Vimeo")
        {
          changeTypeInput(input, 'text');
        }
        if (valueSelected == "File" || valueSelected == "Image"){
          changeTypeInput(input, "file");
        }
        });
  });
  var i = 0;
  $(".selector").each(function(){
    var value = $(this).parent().parent().parent().find(':hidden').val();
    projects[i]= {
        'project_id' : value,
        'project_select' : false
      };
      // for (var i = projects.length - 1; i >= 0; i--) {
      //   console.log(projects[i]['project_id']+'='+projects[i]['project_select']);
      // };
    i++;
    $(this).on('click', function(e){
      e.preventDefault();
      var thumbnail = $(this).parent().parent().parent();
      var value = thumbnail.find(':hidden').val();
      
      if(thumbnail.css('border-width') == '1px')
      {
        nbProjectSelected++;
        thumbnail.css('border-width', '10px');
        projects=setProject(projects, value);
      // for (var i = projects.length - 1; i >= 0; i--) {
      //   console.log(projects[i]['project_id']+'='+projects[i]['project_select']);
      // };
        $(this).children(':last-child').text("Supprimer du Cahier");
      }else if(thumbnail.css('border-width') == '10px')
      {
        nbProjectSelected--;
        projects=unsetProject(projects, value);
        thumbnail.css('border-width', '1px');
        $(this).children('.glyphicon-class').text("Ajouter au Cahier");
      }
      $(".numberProject").text(nbProjectSelected);
      if(nbProjectSelected > 0)
      {
        $(".numberProject").parent().removeClass('disabled');
      }else {
        $(".numberProject").parent().addClass('disabled');
      }
    })

  })
  $(".addBook").on('click', function(){
  for (var i = 0; i < projects.length; i++) {
    if(projects[i]['project_select'] == true)
    {
      $(this).before("<input type='hidden' name='project["+i+"]' value='"+projects[i]['project_id']+"'/>");
    }
  };
  })
  if (typeof availableTags != "undefined"){
    $( ".tagInput").autocomplete({
      source: availableTags,
      messages: {
        noResults: '',
        results: function() {}
    }
    });
  };
  // $('li.tag').on('click', function () {
  //   // alert($(this).parent().parent('.tag_container').find('.tagInput').val($(this).html())+'           '+$(this).html());
  //   $(this).parent().parent('.tag_container').find('.tagInput').val($(this).html());  
  // });

  // $('.tagInput').on('keyup select', function(){
  //   var input_content = $.trim($(this).val());
  //   // alert($(this).parent().parent().find('ul.tags_select>li').text());
  //   if (!input_content) {
  //          $(this).parent().parent().find('ul.tags_select>li').show();
  //       } else {
  //            $(this).parent().parent().find('ul.tags_select>li').show().not(':contains(' + input_content  + ')').hide();
  //       }

  // });
  // $('.tagInput').blur('select', function(){
  //   $(this).parent().parent().find('ul.tags_select').hide();
  // })
  
  $("#project_search_submit").on('click', function(){
    var search= $(this).parent().find('#project_search').val();
    if (search != '') {
       var result= searchToArray(search);
    for(string in result){
      if (result[string] == parseInt(result[string]))
      {
        // alert(result[string]);
      }
    }
  }
  });
});