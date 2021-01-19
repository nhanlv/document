var filesToUpload = [];
function UploadFiles() {
    var fileIdCounter = 0;
    $("#files").change(function (e) {
        var output = [];
        for (var i = 0; i < e.target.files.length; i++) {
            fileIdCounter++;
            var file = e.target.files[i];
            var fileId = "file" + fileIdCounter;
            filesToUpload.push({id: fileId, file: file});
            //var removeLink = "<a class=\"removeFile\" href=\"#\" data-fileid=\"" + fileId + "\">Remove</a>";
            var removeLink = `<div class=\"column-img\"><img src=\"${URL.createObjectURL(file)}\"><div class=\"overlay\">${escape(file.name)}</div><div class=\"top-right\"><i class=\"fa fa-trash\" id=\"remove\" data-fileid=\"${fileId}\"></i></div></div>`;
            output.push(removeLink);
        }
        $(this).parent().siblings(".list-files").append(output.join(""));
        e.target.value = null;
    });
    $(document).on("click", "#remove", function (e) {
        e.preventDefault();
        var fileId = $(this).parent().children("i").data("fileid");
        for (var i = 0; i < filesToUpload.length; ++i) {
            if (filesToUpload[i].id === fileId)
                filesToUpload.splice(i, 1);
        }
        $(this).parents(".column-img").remove();
    });
}
getListFiles = () => filesToUpload;