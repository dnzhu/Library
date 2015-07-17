var Dialog = (function () {

    function Dialog (config) {
        // 默认配置
        this.config = {
            isShow: true
        };

        $.extend(this.config, config)

        $.proxy(init, this)();
        $.proxy(initEvent, this)();
    }

    Dialog.prototype.show = function () {
        // 弹出遮罩层
		$.proxy(resize,this)();
        showOverlay();

        this.dialogEle.show();
    };

    Dialog.prototype.hide = function () {
        this.dialogEle.hide();
        hideOverlay();

        if (this.config.beforeClose) {
            this.config.beforeClose.apply(this);
        }
    };

    Dialog.prototype.destory = function () {
        this.dialogEle.remove();
        hideOverlay();
    };

    function init() {
        var dialogHtmlArray = [];
        var dialogEle, position;

        dialogHtmlArray.push('<div class="dialog">');
        dialogHtmlArray.push('  <a href="javascript:;" class="dialog-close" hidefocus="true"></a>');
        dialogHtmlArray.push(this.config.html);
        dialogHtmlArray.push('</div>');

        dialogEle = $(dialogHtmlArray.join(''));

        this.element = dialogEle;
        $('body').append(dialogEle);

        if (this.config.width) {
            dialogEle.width(this.config.width);
        }

        if (this.config.height) {
            dialogEle.height(this.config.height);
        }

        if (!this.config.isShow) {
            dialogEle.hide();
        }

        position = positionDialog(dialogEle);
        
        dialogEle.css(position);

        this.dialogEle = dialogEle;

        // 弹出遮罩层
        showOverlay();
    }

    function showOverlay() {
        var overLayEle = $('<div id="overlay" class="overlay"></div>');

        var clientSize = getDocumentSize();
        var viewPortWidth = clientSize.width;
        var viewPortHeight = clientSize.height;

        overLayEle.width(viewPortWidth);
        overLayEle.height(viewPortHeight);

        $('body').append(overLayEle);
    }

    function hideOverlay(argument) {
        $('#overlay').remove();
    }

    function resizeOverlay() {
        var overLayEle = $('#overlay');
        var clientSize = getDocumentSize();
        var viewPortWidth = clientSize.width;
        var viewPortHeight = clientSize.height;


        overLayEle.width(viewPortWidth);
        overLayEle.height(viewPortHeight);
    }

    function positionDialog(dialogEle) {
        var clientSize = getClinetSize();
        var viewPortWidth = clientSize.width;
        var viewPortHeight = clientSize.height;

        var dialogWidth = dialogEle.width();
        var dialogHeight = dialogEle.height();

        return {
            left: (viewPortWidth - dialogWidth) / 2,
            top: (viewPortHeight - dialogHeight) /2 + $(window).scrollTop()
        };
    }

    function getClinetSize() {
        var size = {};
        var documentElement = document.documentElement;

        size.height = documentElement.clientHeight;
        size.width = documentElement.clientWidth;

        return size;
    }

    function getDocumentSize() {
        var size = {};
        var documentElement = document.documentElement;

        size.width = documentElement.scrollWidth;
        size.height = documentElement.scrollHeight > documentElement.clientHeight ? documentElement.scrollHeight : documentElement.clientHeight;

        return size;
    }

    function resizeDialog() {
        var dialogEle = this.dialogEle;
        var position = positionDialog(dialogEle);

        dialogEle.css(position);
    }

    function resize() {
        resizeOverlay();
        $.proxy(resizeDialog, this)();
    }

    function initEvent () {
        var dialogEle = this.dialogEle;

        dialogEle.on('click', '.dialog-close', $.proxy(this.hide, this));

        $(window).on('resize', $.proxy(resize, this));
    }

    return Dialog;
})();
