<?php
require('./../config/config.php');
$db = new db();

$slCode = "SELECT * FROM file_upload ORDER BY id ASC";
$qrCode = $db->Query($slCode);
$filename = "";
if ($db->NumRows($qrCode) > 0) {
    while ($arCode = $db->FetchArray($qrCode)) {
        //echo strlen($arCode['dataurl']);
        $filename .= "<div class=\"column-img\"><img src=\"" . $arCode['dataurl'] . "\" filename=\"" . $arCode['name'] . "\" name='fileupload'><div class=\"overlay\">" . $arCode['name'] . "</div><div class=\"top-right\"><i class=\"fa fa-trash\" id=\"remove\" data-fileid=\"file" . $arCode['id'] . "\"></i></div></div>";
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Bootstrap</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class='logo-container'></div>
        <div class="navbar">
            <a class="active" href="#home">Trang chủ</a>
            <div class="dropdown">
                <button class="dropbtn">Dữ liệu nền
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#">Thông tin công ty</a>
                    <a href="#">Thông tin kho</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Đơn hàng 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#">Đơn đặt hàng </a>
                    <a href="#">Hóa đơn VAT</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Kho 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#">Phiếu nhập</a>
                    <a href="#">Sổ xuất hàng</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="container body">
                <h2>THÊM THÔNG TIN</h2>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="flex-container">
                        <div class="row">
                            <div class="column-input">
                                <label for="input">Input</label>
                                <input type="text" id="input" name="input">
                            </div>
                            <div class="column-input">
                                <label for="select">Select</label>
                                <select id="select" name="select">
                                    <option value="australia">Australia</option>
                                    <option value="canada">Canada</option>
                                    <option value="usa">USA</option>
                                </select>
                            </div>
                            <div class="column-input">
                                <div class="autocomplete">
                                    <label for="autocomplete">Autocomplete</label>
                                    <input type="text" id="autocomplete" name="autocomplete">
                                </div>
                            </div>
                            <div class="column-input">
                                <label for="textarea">Textarea</label>
                                <textarea id="textarea" name="textarea"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column-input">
                                <label class="container-checkbox">Checkbox
                                    <input type="checkbox" checked="checked">
                                    <span class="checkmark checkboxmark"></span>
                                </label>    
                            </div>
                            <div class="column-input">
                                <label class="container-checkbox">Radio one
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark radiomark"></span>
                                </label>
                                <label class="container-checkbox">Radio two
                                    <input type="radio" name="radio">
                                    <span class="checkmark radiomark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="file-uploads">
                                <i class="fa fa-plus-circle"></i> Upload files
                                <input type="file" name="files" id="files" multiple/>
                            </div>
                            <div class="list-files"><?php echo $filename; ?></div>
                        </div>
                        <div class="row">

                        </div>    
                    </div>
                </form>
            </div>
            <div class="pagination">
                <div class='center'>
                    <button class="btn info" id="submit">Lưu lại</button>
                    <button class="btn info">Làm mới</button>
                </div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/upload.js"></script>
    <script src="../js/autocomplete.js"></script>
</html>
<script>
    $(document).ready(function () {
//        code upload files
        $('input[type=file]').change(function () {//Browse file trên máy xong trả lại kết quả trên textbox là tên file vừa tải
            var select = $(this);
            for (var i = 0; i < this.files.length; i++) {

                if (this.files[i]) {
                    var reader = new FileReader();
                    reader.filename = this.files[i].name;
                    reader.onload = function (e) {
                        var fileId = "file" + i;
                        var removeLink = `<div class=\"column-img\"><img src=\"${e.target.result}\" filename=\"${e.target.filename}\" name='fileupload'><div class=\"overlay\">${e.target.filename}</div><div class=\"top-right\"><i class=\"fa fa-trash\" id=\"remove\" data-fileid=\"${fileId}\"></i></div></div>`;
                        select.parent().siblings(".list-files").append(removeLink);
                        e.target.value = null;
                    }
                    reader.readAsDataURL(this.files[i]);
                }
            }
        });
        $(document).on("click", "#remove", function () {
            $(this).parents(".column-img").remove();
        });
        $("#submit").click(function () {
            const files = [];
            $('img[name=fileupload]').each(function () {
                let src = $(this).attr('src');
                let filename = $(this).attr('filename');
                files.push({src: src, filename: filename});
            });
            $.post("http://localhost/fontawesome/page/proccess.php", {Api: "UPLOAD_FILE", files: JSON.stringify(files)}, function (data) {
                if (parseInt(data)) {
                    window.location.reload();
                }
            });
        });
//        test
        function abc() {
            return new Promise((resolve, reject) => {
                setTimeout(function () {
                    if (true) {
                        resolve(console.log("abc"));
                    } else {
                        reject('s');
                    }

                }, 1000);
            });
        }
        function aaa() {
            return new Promise((resolve,reject)=>{
                console.log("nhan");
            });
            
        }
        async function run() {
            var a = await abc();
            var b = await aaa();
            return [a,b];
        }
        run().then(data=>console.log(data)).catch (err=>console.log(new Error() +err));

    });
</script>
