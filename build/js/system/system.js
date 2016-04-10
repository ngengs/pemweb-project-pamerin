$(document).ready(function(){
	if($('#header .navbar').length){
		$('#header .navbar').affix({
		  offset: {
		    top: $('#wrapper').offset().top - 75
		  }
		})
	}
	if($('#modal-search').length){
		$('#modal-search').on('shown.bs.modal', function () {
		  $('#search-input').focus()
		});
	}
	if($('.cards-as-link').length){
		$('.cards-as-link').click(function(e){
			var $id = $(this).data('post');
			var $target = $(this).data('type');
			var $user = $(this).data('creator');
			if($id !== null && $target != null && $user != null){
				location.href = base_url+$target+'/'+$user+'/'+$id;
			}
		});
		$('.cards-as-link a').click(function(e){
			e.stopPropagation();
		});
		$('.cards-as-link button').click(function(e){
			e.preventDefault();
			e.stopPropagation();
			$(this).dropdown();
		});
	}
	if($('.input-file').length){
		$('.input-file').fileinput({
			maxFileCount: 2,
			allowedFileExtensions: ['jpg','png'],
			maxFileSize: 2048,
			maxFileCount: 10,
			removeIcon: '<span class="fa fa-close"></span>',
			browseIcon: '<span class="fa fa-folder-open"></span>',
			showUpload: false,
		});
	}
	
	if($('.edit-post-btn').length){
		$('.edit-post-btn').click(function(e){
			e.preventDefault();
			var $id = $(this).data('post');
			var $action = $(this).data('action');
			var $show = true;
			if($action == 'hide'){
				$show = false;
			}
			var $cards = $('.cards[data-post="'+$id+'"]');
			if($show){
				$cards.find('.edit-post-btn[data-action="show"]').hide();
				$cards.find('.cards-body-content').hide();
				$cards.find('.cards-body-form').show();
			}else{
				$cards.find('.edit-post-btn[data-action="show"]').show();
				$cards.find('.cards-body-content').show();
				$cards.find('.cards-body-form').hide();
			}
		});
	}
	
	if($('.edit-comment-btn').length){
		$('.edit-comment-btn').click(function(e){
			e.preventDefault();
			var $id = $(this).data('comment');
			var $action = $(this).data('action');
			var $show = true;
			if($action == 'hide'){
				$show = false;
			}
			var $cards = $('.media[data-comment="'+$id+'"]');
			if($show){
				$cards.find('.edit-comment-btn[data-action="show"]').hide();
				$cards.find('.comment-box').hide();
				$cards.find('.comment-edit-form').show();
			}else{
				$cards.find('.edit-comment-btn[data-action="show"]').show();
				$cards.find('.comment-box').show();
				$cards.find('.comment-edit-form').hide();
			}
		});
	}
	
	if($('.delete-post-btn').length){
		$('.delete-post-btn').click(function(e){
			e.preventDefault();
			var $id = $(this).data('post');
			var $target = $(this).data('type');
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_DANGER,
	            title: 'Warning',
	            message: 'Are you sure want delete this post?',
	            buttons: [{
	                label: 'Cancel',
	                action: function(dialog) {
	                    dialog.close();
	                }
	            }, {
	                label: 'Yes',
	                icon: 'fa fa-trash',
	                cssClass: 'btn-danger',
	                action: function(dialog) {
	                    location.href=base_url+$target+'/'+$id;
	                }
	            }]
	        });
		});
	}
	
	if($('.delete-comment-btn').length){
		$('.delete-comment-btn').click(function(e){
			e.preventDefault();
			var $id = $(this).data('post');
			var $id_comment = $(this).data('comment');
			var $userpost = $(this).data('userpost');
			var $target = $(this).data('type');
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_DANGER,
	            title: 'Warning',
	            message: 'Are you sure want delete this comment?',
	            buttons: [{
	                label: 'Cancel',
	                action: function(dialog) {
	                    dialog.close();
	                }
	            }, {
	                label: 'Yes',
	                icon: 'fa fa-trash',
	                cssClass: 'btn-danger',
	                action: function(dialog) {
	                    location.href=base_url+$target+'/'+$userpost+'/'+$id+'/'+$id_comment;
	                }
	            }]
	        });
		});
	}
	
	if($('.link-script').length){
		$('.link-script').click(function(e){
			e.preventDefault();
			location.href=$(this).data('href');
		});
	}
	if(typeof moment != "undefined"){
		moment.updateLocale('en', {
		    relativeTime : {
		        future: "in %s",
		        past:   "%s ago",
		        s:  "a sec",
		        m:  "1 min",
		        mm: "%d min",
		        h:  "1 h",
		        hh: "%d h",
		        d:  "1 d",
		        dd: "%d d",
		        M:  "1 mon",
		        MM: "%d mon",
		        y:  "1 y",
		        yy: "%d y"
		    }
		});
	}
	
	if($('.formated-time').length){
		$('.formated-time').each(function(e){
			var $time = $(this).html();
			var $range = moment($time).fromNow(true);
			$(this).html($range);
		});
	}
	
	if($('.timeline-masonry').length){
		// init Masonry
		var $grid = $('.timeline-masonry').masonry({
		  itemSelector: '.cards-column',
		  // use element for option
		  columnWidth: '.cards-column',
		  percentPosition: true
		});
		// layout Masonry after each image loads
		$grid.imagesLoaded().progress( function() {
		  $grid.masonry('layout');
		});
	}
	
	if($('.img-popup').length){
		
	}
	
	if($('.grid-image').length){
		// $('.grid-image').each(function(e){
			// var $this = $(this);
			// $this.imagesLoaded().progress( function() {
			  // $this.isotope({
			    // itemSelector: '.grid-image-photo',
			    // masonry: {
			      // columnWidth: 50
			    // }
			  // });
			// });
		// });
	}
	if($('.number-change').length){
		$('.number-change').each(function(e){
			var $this = $(this);
			var $number = $this.html();
			var $number_change = number_change($number,1);
			$this.html($number_change);
		});
	}
	
	
	function number_change(num, digits) {
	  var si = [
	    { value: 1E18, symbol: "E" },
	    { value: 1E15, symbol: "P" },
	    { value: 1E12, symbol: "T" },
	    { value: 1E9,  symbol: "G" },
	    { value: 1E6,  symbol: "M" },
	    { value: 1E3,  symbol: "K" }
	  ], i;
	  for (i = 0; i < si.length; i++) {
	    if (num >= si[i].value) {
	      return (num / si[i].value).toFixed(digits).replace(/\.0+$|(\.[0-9]*[1-9])0+$/, "$1") + si[i].symbol;
	    }
	  }
	  return num.toString();
	}
});