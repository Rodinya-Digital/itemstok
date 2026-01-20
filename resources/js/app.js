require('./bootstrap');
require('select2');
import 'select2/dist/css/select2.css';
require('@aacassandra/jquery_upload_preview/assets/js/jquery.uploadPreview.min');

!function () {
    if (jQuery && jQuery.fn && jQuery.fn.select2 && jQuery.fn.select2.amd) var n = jQuery.fn.select2.amd;
    n.define("select2/i18n/tr", [], function () {
        return {
            errorLoading: function () {
                return "Sonuç yüklenemedi"
            }, inputTooLong: function (n) {
                return n.input.length - n.maximum + " karakter daha girmelisiniz"
            }, inputTooShort: function (n) {
                return "En az " + (n.minimum - n.input.length) + " karakter daha girmelisiniz"
            }, loadingMore: function () {
                return "Daha fazla…"
            }, maximumSelected: function (n) {
                return "Sadece " + n.maximum + " seçim yapabilirsiniz"
            }, noResults: function () {
                return "Sonuç bulunamadı"
            }, searching: function () {
                return "Aranıyor…"
            }, removeAllItems: function () {
                return "Tüm öğeleri kaldır"
            }
        }
    }), n.define, n.require
}();

window.Vue = require('vue');
import iosAlertView from 'vue-ios-alertview';

Vue.use(iosAlertView);

import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';

Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);

const app = new Vue({
    el: '#app',
    data() {
        return {
            user: AuthUser
        }
    },
    methods: {
        userCan(permission) {
            if (this.user && this.user.allPermissions.includes(permission)) {
                return true;
            }
            return false;
        },
        MakeUrl(path) {
            return BaseUrl(path);
        }
    }
});

tinymce.init({
    selector: '.tiny',
    plugins: 'print preview powerpaste casechange importcss image tinydrive searchreplace autolink directionality advcode visualblocks visualchars fullscreen link mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions linkchecker emoticons advtable',
    toolbar: 'undo redo | bold italic underline strikethrough link image | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify |  numlist bullist checklist | forecolor backcolor casechange removeformat | charmap emoticons | fullscreen  preview print | pageembed anchor codesample | a11ycheck | showcomments addcomment',
    toolbar_mode: 'floating',
    menubar: 'file edit view insert format tools table tc help',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Admin',
});

$('#phone_verify_code_send').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'user_verify_code_send',
        data: {_token: $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        success: function (data) {
            if (data.status == "success") {
                if(data.timer){verifyCodeSecondTime(data.timer);}
                iziToast.success({
                    title: '',
                    message: data.message,
                    position: 'topRight'
                });
            } else {
                if(data.timer){verifyCodeSecondTime(data.timer);}
                iziToast.error({
                    title: '',
                    message: data.message,
                    position: 'topRight'
                });
            }
        },
        error: function (data) {
            iziToast.error({
                title: '',
                message: data.message,
                position: 'topRight'
            });
        }
    });
});

function verifyCodeSecondTime(second) {
    let codeSendButton = $('#phone_verify_code_send');
    let interval = setInterval(codeSendTimerFunc,1000);
    function codeSendTimerFunc() {
        if (second !== 0) {
            second--;
            codeSendButton.text('Tekrar gönder ' + second + ' sn bekleyin.');
            codeSendButton.prop('disabled', true);
        } else {
            clearInterval(interval);
            codeSendButton.text('Tekrar gönder');
            codeSendButton.prop('disabled', false);
        }
    }
}


$('#phone_verify_button').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'verify_phone_code',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            code: $('#phone_verify_code').val()
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.status == "success") {
                iziToast.success({
                    title: '',
                    message: data.message,
                    position: 'topRight'
                });
                location.reload();
            } else {
                iziToast.error({
                    title: '',
                    message: data.message,
                    position: 'topRight'
                });
            }
        },
        error: function (data) {
            iziToast.error({
                title: '',
                message: data.message,
                position: 'topRight'
            });
        }
    });
});



$.uploadPreview({
    input_field: "#image-upload",   // Default: .image-upload
    preview_box: "#image-preview",  // Default: .image-preview
    label_field: "#image-label",    // Default: .image-label
    label_default: "Görsel Seçin",   // Default: Choose File
    label_selected: "Görseli Değiştir",  // Default: Change File
    no_label: false,                // Default: false
    success_callback: null          // Default: null
});
