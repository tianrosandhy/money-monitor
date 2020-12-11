<style>
#media-modal{
	overflow:hidden;
	z-index: 10000;
	background:rgba(0,0,0,.5);
}
#media-modal .modal-content{
	background:transparent;
	border:none;
	box-shadow:none;
}
#media-modal .modal-body{
	padding:0;
	border-radius:5px 0 5px 5px;
	-moz-border-radius:5px 0 5px 5px;
	overflow: hidden;
}
#media-modal .modal-header{
	border:none;
}
#media-modal .close{
	background:#d00;
	color:#fff;
	opacity:1;
	padding:.25em 1em;
	border-radius: 5px 5px 0 0;
	-moz-border-radius: 5px 5px 0 0;
}


.media-item{
	object-fit:cover;
}
.dz-default.dz-message{
	padding:1em;
	font-size:120%;
	text-align:center;
	cursor:pointer;
}	
.btn.active{
	background:#ddd;
}
.media-image-thumb{
	display:block;
	padding:.5em;
	margin-bottom:1em;
	opacity:1;
	text-align:center;
}
.media-image-thumb:hover{
	opacity:.75;
}
.media-image-thumb.selected{
	background:#25c2e3;
	color:#fff;
}

.media-image-container{
	position:relative;
}

.media-image-container .cols{
	float:left;
	margin:.5em;
}



#media-modal{
	overflow:hidden;
}
.filemanager-content{
	position:relative;
	overflow:hidden;
}
.filemanager-detail{
	position:absolute;
	top:1em;
	right:-500px;
	max-width:300px;
	transition:.3s ease;
	-moz-transition:.3s ease;
	-o-transition:.3s ease;
	-webkit-transition:.3s ease;
	-ms-transition:.3s ease;
}
.filemanager-detail.opened{
	top:1em;
	right:1em;
}
.filemanager-detail .closer{
	position:absolute;
	right:.25em;
	top:.25em;
	cursor:pointer;
	width:40px;
	height:40px;
	line-height:40px;
	text-align: center;;
	background:transparent;
	color:#000;
	border-radius:50%;
	transition:.3s ease;
	-moz-transition:.3s ease;
	-webkit-transition:.3s ease;
	-ms-transition:.3s ease;
	-o-transition:.3s ease;
}
.filemanager-detail .closer:hover{
	background:#aaa;
	color:#fff;
	transform:rotate(180deg);
	-moz-transform:rotate(180deg);
	-webkit-transform:rotate(180deg);
	-o-transform:rotate(180deg);
}

.media-image-container{
	transition:.3s ease;
	-moz-transition:.3s ease;
	-o-transition:.3s ease;
	-webkit-transition:.3s ease;
	-ms-transition:.3s ease;
}
.media-image-container.opened{
	margin-right:300px;
}

@media (max-width:768px){
	.media-image-container.opened{
		margin-right:0;
	}
	.filemanager-detail.opened{
		max-width:inherit;
		width:100%;
		background:#fff;
		height:100%;
	}
}




.media-multiple-holder{
	position:relative;
}
.media-multiple-holder .multi-media-container, .media-multiple-holder .square-image{
	float:left;
}
.square-image{
	margin:.5em;
	width:100px;
	height:80px;
	display:block;
	position:relative;
	text-align:center;
	background:#fff;
	cursor:pointer;
	border-radius:5px;
	overflow:hidden;
}
.square-image img{
	width:100%;
	height:100%;
	position:absolute;
	top:0;
	left:0;
	object-fit: cover;
}
.square-image svg{
	position:relative;
	top:-5px;
	width:20px;
	height:20px;
}
.square-image.add{
	border:2px dashed #ccc;	
	display:flex;
	justify-content: center;
	align-content: center;
	flex-flow: column;
}
.square-image.add:hover{
	border-color:#5369f8;
	color:#5369f8;
}

.multi-closer{
	position:absolute;
	top:0;
	right:0;
	line-height:24px;
	width:30px;
	padding-top:5px;
	background:#d00;
	color:#fff;
	border-radius:0 5px 0 5px;
	opacity:0;
	transition:.3s ease;
	-moz-transition:.3s ease;
	-o-transition:.3s ease;
	-webkit-transition:.3s ease;
	-ms-transition:.3s ease;
	z-index:2;
}
.multi-closer svg{
	width:18px;
	height:18px;
}
.square-image:hover .multi-closer{
	opacity:1;
}
.square-image .trigger-upload-image{
	position:absolute;
	top:0;
	left:0;
	width:100%;
	height:100%;
	display:block;
}
</style>


<!-- popup content -->
<div class="modal fade" tabindex="-1" role="dialog" id="media-modal" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-xl-3 col-6 mb-2">
						<a href="#" class="btn btn-white bg-white trigger-upload-tab">
							<i class="icon" data-feather="upload"></i> <span class="d-none d-sm-inline-block">Upload Image</span>
						</a>
					</div>
					<div class="col-xl-3 d-none d-lg-block d-xl-block"></div>
					<div class="col-xl-3 col-6 text-right">
						<div class="btn-group">
							<button type="button" class="refresh-button btn btn-info" title="Refresh">
								<i class="icon" data-feather="refresh-cw"></i>
							</button>
							<button type="button" class="sort-asc btn btn-white" title="Older First">
								<i class="icon" data-feather="arrow-down"></i>
							</button>
							<button type="button" class="sort-desc btn btn-white desc" title="Older Last">
								<i class="icon" data-feather="arrow-up"></i>
							</button>
						</div>
					</div>
					<div class="col-xl-3 col-6">
						<form action="" class="media-search">
							<div class="input-group">
								<input type="search" autocomplete="off" class="form-control" name="keyword" id="media-search-keyword" placeholder="Search Image">
								<div class="input-group-append">
									<button type="button" class="search-button btn btn-secondary" title="Search">
										<i class="icon" data-feather="search"></i>
									</button>
								</div>						
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="card-body filemanager-content">

			</div>
			<div class="card-body filemanager-upload" style="display:none;">
				<?php
				$max_size = (file_upload_max_size() / 1024 /1024);
				?>
				<div class="dropzone custom-dropzone dz-clickable mydropzone" data-hash="" upload-limit="{{ intval($max_size) }}" data-target="{{ route('admin.media') }}"></div>
				<div>
					<span style="opacity:.5; font-size:.7em; padding:0 .75em;">Maximum Upload Size : {{ number_format($max_size, 2) }} MB</span>
				</div>
				<div class="my-3">
					<a href="#" class="trigger-filemanager btn btn-sm btn-secondary"><< Back to Images Gallery</a>
				</div>
			</div>
		</div>

      </div>
    </div>
  </div>
</div>




<!-- for media input -->
<script>
var FILEMANAGER_PAGE = 1;
var ACTIVE_EDITOR;
$(function(){
	$(document).on('click', ".trigger-upload-image", function(e){
		e.preventDefault();
		//set data-hash to filemanager modal
		hash = $(this).closest(".input-image-holder").attr('data-hash');
		$("#media-modal").attr('data-hash', hash);
		$("#media-modal [data-hash]").attr('data-hash', hash);
		$("#media-modal").modal('show');
		loadFileManager(1, true);
	});

	$(document).on('click', '.input-image-holder .remove-image', function(e){
		e.preventDefault();
		par = $(this).closest('.input-image-holder');
		par.find('.listen-image-upload').val('');

		mi = par.find('img.media-item');
		mi.attr('src', mi.attr('data-fallback'));
	});

	$(document).on('click', '.square-image.add', function(e){
		e.preventDefault();
		container = $(this).closest('.media-multiple-holder');
		html = $("#media-multiple-single-item").html();
		container.find('.multi-media-container').append(html);

		container.find('.multi-media-container .square-image:last').attr('data-hash', makeid(30));
		feather.replace();	
	});

	$(document).on('click', '.multi-closer', function(e){
		e.preventDefault();
		tgt = $(this).closest('.square-image');
		tgt.fadeOut(300);
		setTimeout(function(){
			tgt.remove();
		}, 310);
	});

});
</script>


<!-- for file manager -->
<script>
Dropzone.autoDiscover = false;
function initImageDropzone(){
	$(".mydropzone").each(function(){
		var ajaxurl = $(this).data("target");
		var dropzonehash = $(this).attr('data-hash');
		var maxsize = $(this).attr('upload-limit');
		if(maxsize.length == 0){
			maxsize = 2;
		}

		if($(this).find('.dz-default').length == 0){
			$(this).dropzone({
				url : ajaxurl,
				acceptedFiles : 'image/*',
				maxFilesize : maxsize,
				sending : function(file, xhr, formData){
					formData.append("_token", window.CSRF_TOKEN);
					disableAllButtons();
				},
				init : function(){
					this.on("success", function(file, data){
						data = window.JSON.parse(file.xhr.responseText);
						this.removeFile(file);
						enableAllButtons();
					});

					this.on("queuecomplete", function(){
						this.removeAllFiles();
						enableAllButtons();
						afterFinishUpload();
					});
					this.on("error", function(file, err, xhr){
						this.removeAllFiles();
						enableAllButtons();
					});
				}
			});		
		}
	});		
}
$(function(){
	$(document).on('click', ".trigger-upload-tab", function(){
		gotoUpload();
	});
	$(document).on('click', ".trigger-filemanager", function(){
		gotoFilemanager();
	});

	$(document).on('click', '.filemanager-content .pagination a.page-link', function(e){
		e.preventDefault();
		page = parseInt($(this).attr('data-page'));
		loadFileManager(page);
	});

	// trigger utk menjalankan refresh file manager
	$(document).on('click', '.btn.sort-desc', function(){
		$(this).addClass('active');
		$(".btn.sort-asc").removeClass('active');
		loadFileManager();
	});
	$(document).on('click', '.btn.sort-asc', function(){
		$(this).addClass('active');
		$(".btn.sort-desc").removeClass('active');
		loadFileManager();
	});
	$(document).on('submit', '.media-search', function(e){
		e.preventDefault();
		loadFileManager();
	});
	$(document).on('click', '.refresh-button', function(){
		loadFileManager();
	});

	$(document).on('click', '.filemanager-detail .closer', function(e){
		e.preventDefault();
		hideImageDetail();
	});

	if( 
		$(".mydropzone").length || 
		$(".mydropzone-multiple").length
	){
		initImageDropzone();
	}

	$(document).on('click', '.media-image-thumb', function(e){
		e.preventDefault();
		loadImageDetail($(this));
	});

	$(document).on('click', '.filemanager-select-final', function(e){
		e.preventDefault();
		response = {};
		response.thumb = $(".filemanager-thumb-selection").val();
		response.id = $(".filemanager-thumb-selection").attr('data-id');
		response.path = $(".filemanager-thumb-selection").attr('data-path');

		//output format : JSON stringify & url path
		string_response = window.JSON.stringify(response);
		hash_target = $("#media-modal").attr('data-hash');

		//output format : string path utk wysiwyg
		if(window.ACTIVE_EDITOR){
			//for tinymce input : get thumb final URL from ajax
			$.ajax({
				url : window.BASE_URL + '/media/get-image-url',
				type : 'GET',
				dataType : 'html',
				data : response,
				success : function(resp){
					window.ACTIVE_EDITOR.insertContent(resp);
					window.ACTIVE_EDITOR = null;
					resetModalFilemanager();
				},
				error : function(resp){
					alert('Sorry, some error occured when select the image');
					hideLoading();
				}
			});
		}
		else if($(".input-image-holder[data-hash='"+hash_target+"']").length){
			input_target = $(".input-image-holder[data-hash='"+hash_target+"']");
			input_target.find('.listen-image-upload').val(string_response);
			input_target.find('.media-item').attr('src', $(".holder-image").attr('src'));
			resetModalFilemanager();
		}

	});

	$(document).on('click', '.delete-permanently', function(e){
		cf = confirm('Are you sure you want to delete this data? This action cannot be undone.');
		if(cf){
			showLoading();
			media_id = $(this).closest('.filemanager-detail').find('select').attr('data-id');
			$.ajax({
				url : window.BASE_URL + '/remove-media/' + media_id,
				type : 'POST',
				dataType : 'json',
				data : {
					_token : window.CSRF_TOKEN
				},
				success : function(resp){
					loadFileManager(window.FILEMANAGER_PAGE);
				},
				error : function(resp){
					hideLoading();
				}
			});
		}
	});
});

function resetModalFilemanager(){
	$("#media-modal").modal('hide');
	$("#media-modal").find('.opened').removeClass('opened');
	$("#media-modal").find('.selected').removeClass('selected');
}

function gotoUpload(){
	$("#media-modal .card-header").fadeOut();
	$(".filemanager-content").slideUp();
	$(".filemanager-upload").slideDown();
}

function gotoFilemanager(reload){
	reload = reload || true;
	$(".filemanager-content").slideDown();
	$(".filemanager-upload").slideUp();
	$("#media-modal .card-header").fadeIn();

	if(reload){
		loadFileManager();
	}
	feather.replace();
}

function afterFinishUpload(){
	gotoFilemanager(true);
}

function loadFileManager(page, ignore_loading){
	page = page || 1;
	ignore_loading = ignore_loading || false;

	if(!ignore_loading){
		showLoading();
	}

	keyword = $("#media-search-keyword").val();
	sort_dir = $(".btn.sort-asc").hasClass('active') ? 'asc' : 'desc';
	$.ajax({
		url : window.BASE_URL + '/file-manager',
		type : 'POST',
		dataType : 'html',
		data : {
			keyword : keyword,
			sort_dir : sort_dir,
			page : page
		},
		success : function(resp){
			$(".filemanager-content").html(resp);
			feather.replace();
			hideLoading();
		},
		error : function(resp){
			toastr['error']('Sorry, we cannot process your request right now');
			hideLoading();
		}
	});
}

function loadImageDetail(click_instance){
	$(".media-image-container .selected").removeClass('selected');
	click_instance.addClass('selected');
	thumb_src = click_instance.attr('data-src');
	media_id = click_instance.attr('data-media-id');
	filename = click_instance.attr('data-filename');
	path = click_instance.attr('data-origin');
	media_url = window.STORAGE_URL + path;

	$(".filemanager-detail img").attr('src', thumb_src);
	$(".filemanager-detail .holder-title").html(filename);
	$(".filemanager-detail .holder-url").attr('href', media_url).html(media_url);
	$(".filemanager-detail .filemanager-thumb-selection").attr('data-id', media_id);
	$(".filemanager-detail .filemanager-thumb-selection").attr('data-path', path);
	$(".filemanager-content, .media-image-container, .filemanager-detail").addClass('opened');
	feather.replace();	
}

function hideImageDetail(){
	$(".filemanager-content, .media-image-container, .filemanager-detail").removeClass('opened');
	$(".media-image-container .selected").removeClass('selected');
}
</script>


<!-- for input -->
<script>
function openTinyMceMedia(target){
	window.ACTIVE_EDITOR = target;
	$("#media-modal").modal('show');
	loadFileManager(1, true);
}	
</script>