function ImgSlider_submit()
{
	if(document.ImgSlider_form.ImgSlider_path.value=="")
	{
		alert("Please enter the image path.")
		document.ImgSlider_form.ImgSlider_path.focus();
		return false;
	}
	else if(document.ImgSlider_form.ImgSlider_link.value=="")
	{
		alert("Please enter the target link.")
		document.ImgSlider_form.ImgSlider_link.focus();
		return false;
	}
	else if(document.ImgSlider_form.ImgSlider_title.value=="")
	{
		alert("Please enter the image title.")
		document.ImgSlider_form.ImgSlider_title.focus();
		return false;
	}
	else if(document.ImgSlider_form.ImgSlider_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.ImgSlider_form.ImgSlider_order.focus();
		return false;
	}
	else if(isNaN(document.ImgSlider_form.ImgSlider_order.value))
	{
		alert("Please enter the display order, only number.")
		document.ImgSlider_form.ImgSlider_order.focus();
		return false;
	}
}

function ImgSlider_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_ImgSlider_display.action="admin.php?page=ImgSlider_image_management&ac=del&did="+id;
		document.frm_ImgSlider_display.submit();
	}
}	

function ImgSlider_redirect()
{
	window.location = "admin.php?page=ImgSlider_image_management";
}

function ImgSlider_help()
{
	window.open("http://www.gopiplus.com/work/2011/11/04/wordpress-plugin-image-slider-with-description/");
}