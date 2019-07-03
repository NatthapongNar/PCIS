/**
 * Created by T58385 on 17/10/2559.
 */
(function () {

    'use strict';

    var orginImage = null;
    var cropper;
    var rotateDeg = 0;
    var zoom = 0;
    var selectionOpen = true;

    var modal, file_drop, file_select, show_img_container
        , btnGetImage, btnUndoImage, btnRotateLeft, btnRotateRight
        , btnZoomIn, btnZoomOut, btnDeleteImage, btnCropImage, btnSelectImageArea, cropImgResult, spanClose, targetElemnt;

    function getImage() {

        cropper.clear();

        cropImgResult.setAttribute("src", cropper.getCroppedCanvas().toDataURL("image/jpeg", 1.0));

        targetElemnt.style.display = "none";
        cropImgResult.parentElement.style.display = "block";

        deleteImage();
        modal.style.display = "none";
        modal.remove();
    }

    function cropImage() {
        selectionOpen = false;
        btnSelectImageArea.classList.remove("icon-active");
        btnGetImage.disabled = false;
        btnUndoImage.disabled = false;
        cropper.replace(cropper.getCroppedCanvas().toDataURL("image/jpeg", 1.0));
        cropper.clear();
    }

    function selectImageArea() {
        selectionOpen = selectionOpen ? false : true;
        if (selectionOpen) {
            cropper.crop();
            btnSelectImageArea.classList.add("icon-active");
        }
        else {
            cropper.clear();
            btnSelectImageArea.classList.remove("icon-active");
        }
    }

    function undoImage() {
        selectionOpen = true;
        btnSelectImageArea.classList.add("icon-active");
        btnGetImage.disabled = true;
        btnUndoImage.disabled = true;
        cropper.replace(orginImage);
        cropper.reset();
    }

    function rotateLeft() {
        if (rotateDeg > 0) {
            rotateDeg = 0;
        }
        rotateDeg -= 1;
        cropper.rotate(rotateDeg);
    }

    function rotateRight() {
        if (rotateDeg < 0) {
            rotateDeg = 0;
        }
        rotateDeg += 1;
        cropper.rotate(rotateDeg);
    }

    function zoomIn() {
        if (zoom > 0) {
            zoom = 0;
        }
        zoom += .1;
        cropper.zoom(zoom);
        console.log(zoom);
    }

    function zoomOut() {
        if (zoom < 0) {
            zoom = 0;
        }
        zoom -= .1;
        cropper.zoom(zoom);
        console.log(zoom);
    }

    function deleteImage() {
        setTimeout(function () {
            if (cropper)
                cropper.destroy();

            btnGetImage.disabled = true;
            btnUndoImage.disabled = true;
            btnDeleteImage.disabled = true;
            show_img_container.style.display = 'block';
            if (document.getElementsByClassName("view-container")[0])
                document.getElementsByClassName("view-container")[0].style.display = "none";
        }, 400);

        document.getElementsByClassName("img-toolbar")[0].classList.remove("active");
    }

    function $id(id) {
        return document.getElementById(id);
    }

    function FileDragHover(e) {
        e.stopPropagation();
        e.preventDefault();

        switch (e.type) {
            case "dragover":
                file_drop.classList.add("img-container-filedrop");
                break;
            default :
                file_drop.classList.remove("img-container-filedrop");
                break;
        }
    }

    function FileSelectHandler(e) {

        FileDragHover(e);

        var files = e.target.files || e.dataTransfer.files;

        if (files[0].type.indexOf("image") >= 0) {

            //$id("result_img");

            var reader = new FileReader();

            reader.onload = function () {
                orginImage = reader.result;
                createCropTool();
            };

            reader.readAsDataURL(files[0]);
        }
    }

    function createCropTool(selectPicture) {
        var imgView;
        if (document.getElementsByClassName('view-container')[0].querySelector("img")) {
            imgView = document.getElementsByClassName('view-container')[0].querySelector("img");
        }
        else {
            imgView = document.getElementsByClassName('view-container')[0].appendChild(document.createElement("img"));
        }

        btnSelectImageArea.classList.add("icon-active");
        document.getElementsByClassName("img-toolbar")[0].classList.add("active");
        document.getElementsByClassName("view-container")[0].style.display = "block";

        if (selectPicture) {
            orginImage = selectPicture;
            imgView.setAttribute("src", selectPicture);
        }
        else {
            imgView.setAttribute("src", orginImage);
        }

        if (!cropper) {
            cropper = new Cropper(imgView, {
                dragMode: 'move'
            });
        }
        else {
            cropper.destroy();
            cropper = new Cropper(imgView, {
                dragMode: 'move'
            });
        }

        btnDeleteImage.disabled = false;
        show_img_container.style.display = 'none';
    }

    function findElemnt(el, name) {
        return el.querySelector('#' + name);
    }

    function cancelImage(e) {
        console.log(e.target.nextElementSibling);
        e.target.nextElementSibling.removeAttribute('src');
        e.target.parentElement.style.display = "none";
        e.target.parentElement.nextElementSibling.style.display = "block";
    }

    function swapImage() {
        var img1 = $id("result_IDCard");
        var img2 = $id("result_TLACard");

        if (!img1.src && img2.src) {
            img1.src = img2.src;
            img1.parentElement.style.display = "block";
            img1.parentElement.nextElementSibling.style.display = "none";

            img2.removeAttribute('src');
            img2.parentElement.style.display = "none";
            img2.parentElement.nextElementSibling.style.display = "block";
        }
        else if (img1.src && !img2.src) {
            img2.src = img1.src;
            img2.parentElement.style.display = "block";
            img2.parentElement.nextElementSibling.style.display = "none";

            img1.removeAttribute('src');
            img1.parentElement.style.display = "none";
            img1.parentElement.nextElementSibling.style.display = "block";
        }
        else {
            var imgData1 = img1.src, imgData2 = img2.src;
            $id("result_IDCard").src = imgData2;
            $id("result_TLACard").src = imgData1;
        }
    }

    function openModal(e) {

        targetElemnt = e.currentTarget.parentElement;

        var body = e.currentTarget.getAttribute("data-modal");

        var html = $id(body).innerHTML;

        cropImgResult = $id(e.currentTarget.getAttribute("data-result"));

        //var parser = new DOMParser();
        //var el = parser.parseFromString(html, "text/xml");
        //modal.querySelector(".modal-content").appendChild(el);

        //document.appendChild(el);

        var div = document.createElement('div');
        div.innerHTML = html;
        while (div.children.length > 0) {
            modal = findElemnt(div, 'myModal');
            file_drop = findElemnt(div.children[0], "img-container");
            file_select = findElemnt(div.children[0], "file-select");
            show_img_container = findElemnt(div.children[0], 'show-img-container');
            btnGetImage = findElemnt(div.children[0], 'get-image');
            btnUndoImage = findElemnt(div.children[0], 'undo-image');
            btnRotateLeft = findElemnt(div.children[0], 'rotate-left');
            btnRotateRight = findElemnt(div.children[0], 'rotate-right');
            btnZoomIn = findElemnt(div.children[0], 'zoom-in');
            btnZoomOut = findElemnt(div.children[0], 'zoom-out');
            btnDeleteImage = findElemnt(div.children[0], 'delete-image');
            btnCropImage = findElemnt(div.children[0], 'crop-image');
            btnSelectImageArea = findElemnt(div.children[0], 'select-image');
            spanClose = div.children[0].querySelector(".close");
            document.body.appendChild(div.children[0]);
        }

        //modal.querySelector(".modal-content").innerHTML = $id(body).innerHTML;

        //var file_drop = $id("img-container");
        //var file_select = $id("file-select");
        //var show_img_container = $id('show-img-container');
        //var btnGetImage = $id('get-image');
        //var btnUndoImage = $id('undo-image');
        //var btnRotateLeft = $id('rotate-left');
        //var btnRotateRight = $id('rotate-right');
        //var btnZoomIn = $id('zoom-in');
        //var btnZoomOut = $id('zoom-out');
        //var btnDeleteImage = $id('delete-image');
        //var btnCropImage = $id('crop-image');
        //var btnSelectImageArea = $id('select-image');


        btnGetImage.addEventListener("click", getImage, false);
        btnUndoImage.addEventListener("click", undoImage, false);
        btnRotateLeft.addEventListener("click", rotateLeft, false);
        btnRotateRight.addEventListener("click", rotateRight, false);
        btnZoomIn.addEventListener("click", zoomIn, false);
        btnZoomOut.addEventListener("click", zoomOut, false);
        btnDeleteImage.addEventListener("click", deleteImage, false);
        btnCropImage.addEventListener("click", cropImage, false);
        btnSelectImageArea.addEventListener("click", selectImageArea, false);

        file_select.addEventListener("change", FileSelectHandler, false);

        file_drop.addEventListener("dragover", FileDragHover, false);
        file_drop.addEventListener("dragleave", FileDragHover, false);
        file_drop.addEventListener("drop", FileSelectHandler, false);

        spanClose.onclick = function () {
            deleteImage();
            modal.style.display = "none";
            modal.remove();
        };

        if (e.target.src) {
            setTimeout(function () {
                createCropTool(e.target.src);
            });
        }

        modal.style.display = "block";
    }

    var showWarningMsg = true;
    var beforePrint = function () {

        if (showWarningMsg) {
            var form = document.getElementsByClassName('no-border');
            for (var i = 0; i < form.length; i++) {
                form[i].style.border = "none";
            }

            var img = document.getElementsByClassName('show-when-print');
            for (var i = 0; i < img.length; i++) {
                img[i].style.opacity = 1;
            }
            alert("โปรดตรวจสอบหน้ากระดาษให้ถูกต้องก่อนพิมพ์อีกครั้ง");
        }

        if (modal.style.display != "none") {
            deleteImage();
            modal.style.display = "none";
            modal.remove();
        }
    };
    var afterPrint = function () {
        var form = document.getElementsByClassName('print-event');
        for (var i = 0; i < form.length; i++) {
            form[i].classList.add("not-show");
        }

        var waterMark = document.getElementsByClassName('water-mark');
        for (var i = 0; i < waterMark.length; i++) {
            waterMark[i].classList.remove("no-watermark");
        }

        var border = document.getElementsByClassName('no-border');
        for (var i = 0; i < border.length; i++) {
            border[i].style.border = "1px solid black";
        }

        var img = document.getElementsByClassName('show-when-print');
        for (var i = 0; i < img.length; i++) {
            img[i].style.opacity = 1;
        }

        showWarningMsg = true;
    };

    function printForm() {
        showWarningMsg = false;

        var form = document.getElementsByClassName('print-event');
        for (var i = 0; i < form.length; i++) {
            form[i].classList.remove("not-show");
        }

        var waterMark = document.getElementsByClassName('water-mark');
        for (var i = 0; i < waterMark.length; i++) {
            waterMark[i].classList.add("no-watermark");
        }

        var img = document.getElementsByClassName('show-when-print');
        for (var i = 0; i < img.length; i++) {
            img[i].style.opacity = 0;
        }

        window.print();
    }

    function printImage() {
        var form = document.getElementsByClassName('no-border');
        for (var i = 0; i < form.length; i++) {
            form[i].style.border = "none";
        }

        var img = document.getElementsByClassName('show-when-print');
        for (var i = 0; i < img.length; i++) {
            img[i].style.opacity = 1;
        }

        window.print();
    }

    if (window.File && window.FileList && window.FileReader) {

        var btn_swap = $id('swap-image');
        btn_swap.addEventListener("click", swapImage, false);

        var btn_cancel_img = document.getElementsByClassName("img-cancel");
        for (var i = 0; i < btn_cancel_img.length; i++) {
            btn_cancel_img[i].addEventListener("click", cancelImage, false);
        }

        var print_form = $id('print-form');
        var print_image = $id('print-image');

        print_form.addEventListener("click", printForm, false);
        print_image.addEventListener("click", printImage, false);

        // Get the modal
        //var modal = document.getElementById('myModal');

        //Get the button that opens the modal
        //var btn = document.getElementById("myBtn");
        var btn = document.getElementsByClassName("open-modal");

        //Get the <span> element that closes the modal
        //var span = document.getElementsByClassName("close")[0];

        //When the user clicks on the button, open the modal
        //btn.onclick = function () {
        //    modal.style.display = "block";
        //};
        for (var i = 0; i < btn.length; i++) {
            btn[i].addEventListener("click", openModal, false);
        }

        // When the user clicks anywhere outside of the modal, close it
        //span.onclick = function () {
        //    deleteImage();
        //    modal.style.display = "none";
        //};

        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function (mql) {
            if (mql.matches) {
                beforePrint();
                //alert("โปรดตรวจสอบหน้ากระดาษให้ถูกต้องก่อนพิมพ์อีกครั้ง");
            }
            else {
                afterPrint();
                //console.log("after print");
            }
        });

        window.onbeforeprint = beforePrint;
        window.onafterprint = afterPrint;

        //window.onclick = function (event) {
        //    if (event.target == modal) {
        //        deleteImage();
        //        modal.style.display = "none";
        //    }
        //
        //    //When the user clicks on <span> (x), close the modal
        //    span.onclick = function () {
        //        modal.style.display = "none";
        //    };
        //
        //}
    }

})();
