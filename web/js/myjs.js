var collectionTagsHolder = $('ul.tags');
var $addTagLink = $('<a href="#" class="add_tag_link">Add tag</a>');
var $newLinkLiTag = $('<ul></ul>').append($addTagLink);


var collectionMediasHolder = $('ul.medias');
var $addMediaLink = $('<a href="#" class="add_media_link">Add Media</a>');
var $newLinkLiMedia = $('<ul></ul>').append($addMediaLink);


var collectionRendersHolder = $('ul.renders');
var $addRenderLink = $('<a href="#" class="add_render_link">Add Render</a>');
var $newLinkLiRender = $('<ul></ul>').append($addRenderLink);

function addForm(collectionHolder, $newLinkLi) {
    var prototype = collectionHolder.attr('data-prototype');

    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    var $newFormLi = $('<li></li>').append(newForm);
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
  collectionTagsHolder.find('li').each(function() {
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
    // $.ajax({
    //   url : '../books/add',
    //   type : 'POST',
    //   data : {'projects' : projects, name : 'test'},
    //   dataType : "json",
    //   error : function(ts){
    //     console.log(ts);
    //     },
    //   sucess : function(){
    //     console.log('sucess');
    //     },
    // })
  for (var i = 0; i < projects.length; i++) {
    if(projects[i]['project_select'] == true)
    {
      // project_array[i]['project_select'] = true;
      // console.log('change to : '+project_array[i]['project_id']+'='+project_array[i]['project_select']);
      $(this).before("<input type='hidden' name='"+i+"' value='"+projects[i]['project_id']+"'/>");
    }
  };
  })

});