//Copy source
function copySource(src, name) {
    $.get("index.php?do=copy&source=" + escape(src) + '&name=' + escape(name));
    $('#clip-board').html(name + ' copied to clipboard.');
    if ($('#paste-single')) {
        $('#paste-single').html('');
    }
    if ($('#paste-multiple')) {
        $('#paste-multiple').html('');
    }
    $('#multi-action').hide();
    uncheckAll();
}
//Open file dialog
function openFileDialog(arg, fileUploading) {
    $('#file-name').html(arg.value);
}
//Uploader image
function uploader() {
    $('#upload').hide();
    $('#uploader').show();
    $('#max-size').html('Uploading..');
}
//Rename
function rename(src, currentName) {
    newName = prompt('New file name.', currentName);
    if (newName === null) {
        return; //break out of the function early
    }
    newPath = src.split('/');
    slashes = newPath.length - 2;
    newPath2 = '';
    for (i = 0; i <= slashes; i++) {
        newPath2 += newPath[i] + '/';
    }
    newPath2 = newPath2 + newName;
    $('#rename_source').val(src);
    $('#rename_destination').val(newPath2);
    $('#rename_form').submit();
}
//Change permission
function changePermissions(src,multiOrSingle,currentPermission) {
    newPermission = prompt('Type new permission attributes.',currentPermission);
    if (newPermission === null) {
        return; //break out of the function early
    }
    $('#permission_type').val(multiOrSingle);
    $('#permission_file').val(src);
    $('#permission_attributes').val(newPermission);
    $('#permissions_form').submit();
}

//Toggle checkbox
var isChecked = false;
function toggleCheckboxes() {

    for (i = 0; i <= document.files_form.elements.length - 1; i++) {

        if (document.files_form.elements[i].type == 'checkbox') {
            if (isChecked == true) {
                document.files_form.elements[i].checked = false;
            } else {
                document.files_form.elements[i].checked = true;
            }
        }


    }
    if (isChecked == true) {
        isChecked = false;
    } else {
        isChecked = true;
    }
    checkedFiles();
}

//Uncheck all checkboxes
function uncheckAll() {
    for (i = 0; i <= document.files_form.elements.length - 1; i++) {
        if (document.files_form.elements[i].type == 'checkbox') {
            document.files_form.elements[i].checked = false;

        }

    }
}
function uncheckMain() {
    $('#checkbox-main').prop('checked', true);
    for (i = 0; i <= document.files_form.elements.length - 1; i++) {
        if (document.files_form.elements[i].type == 'checkbox') {
            if (document.files_form.elements[i].checked == false) {
                $('#checkbox-main').prop('checked', false);
                break;
            } else {
                $('#checkbox-main').prop('checked', true);
            }
        }

    }
    checkedFiles();
}

//Build array of checked files
function checkedFiles() {
    var files = [];
    var queryString = '';
    for (i = 1; i <= document.files_form.elements.length - 1; i++) {
        if (document.files_form.elements[i].type == 'checkbox') {
            if (document.files_form.elements[i].checked == true) {
                files.push(document.files_form.elements[i].value);
                queryString += '&files[]=' + escape(document.files_form.elements[i].value);
            }
        }

    }

    queryString = "index.php?do=multi-copy" + queryString;
    $.get(queryString);
    if ($('#paste-single')) {
        $('#paste-single').html('');
    }
    if ($('#paste-multiple')) {
        $('#paste-multiple').html('');
    }
    $('#clip-board').html('Selected for operation.');
    $('#multi-action').show();
}