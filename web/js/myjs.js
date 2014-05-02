var collectionHolder = $('ul.tags');

var $addTagLink = $('<a href="#" class="add_tag_link">Add tag</a>');
var $newLinkLi = $('<ul></ul>').append($addTagLink);

function addTagForm(collectionHolder, $newLinkLi) {
    var prototype = collectionHolder.attr('data-prototype');

    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#"><span class="glyphicon glyphicon-remove"></span></a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {

        e.preventDefault();

        $tagFormLi.remove();
    });
}

$(document).ready(function () {
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
  // $(".btn-edit").on('click', function (){
  // 		var value = $(this).parent().children(".value-form");
  // 		 $(this).append('<input type="text" name="'+'"value/>');
  // 		alert(value.text());

  // });
	collectionHolder.append($newLinkLi);

    $addTagLink.on('click', function(e) {

        e.preventDefault();

        addTagForm(collectionHolder, $newLinkLi);
        });
    collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });
});