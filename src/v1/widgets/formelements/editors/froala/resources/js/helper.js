function EditorHelper() {
    this.editors = [];
}

EditorHelper.prototype.getButtons = function(type) {
    var items = {
        default: [
            'bold', 'italic', 'underline', 'strikeThrough',
            '|', 'textColor',
            '|', 'paragraphFormat', 'inlineStyle',
            '|', 'align', 'formatOL', 'formatUL', 'insertLink', 'insertImage', 'insertVideo','htmlCode', 'insertTable', 'clearFormatting',
            '|', 'spellChecker',
            '|', 'undo', 'redo',
            '|', 'emoticons', 'referral_bet_link', 'carousel', 'gray_block', 'quote'
        ],
        small: [
            'bold', 'italic', 'underline', 'strikeThrough', 'h2', 'h3',
            '|', 'color', 'backgroundColor',
            '|', 'paragraphFormat', 'intelTemplates', 'inlineStyle',
            '|', 'align', 'formatOL', 'formatUL', 'insertLink', 'insertImage', 'insertVideo','htmlCode', 'insertTable', 'clearFormatting',
            '|', 'spellChecker',
            '|', 'undo', 'redo',
            '|', 'emoticons'
        ]
    }

    return items[type];
};

EditorHelper.prototype.getOptions = function(type) {

    var self = this;

    var items = {
        default : {
            enter : 0,
            attribution : false,
            heightMin : 200,
            toolbarSticky: true,
            toolbarInline: false,
            theme : 'royal', //optional: dark, red, gray, royal
            quickInsertTags: [''],
            toolbarButtons: self.getButtons('default'),
            toolbarButtonsXS: self.getButtons('small'),
            toolbarSticky: true, //default
            linkEditButtons: ['linkOpen', 'linkEdit', 'linkRemove'],
            linkInsertButtons: ['linkBack'],
            imageUploadURL: '/_uploader/img/upload',
            imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL'],
            imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
            imageSizeButtons: false,
            imageEditButtons: ['imageReplace', 'imageAlign', 'imageAlt', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove'],
            imageDefaultAlign: 'center',
            imageDefaultWidth: 0,
            imageMaxSize: 25 * 1024 * 1024,
            tableResizer: true,
            tableResizerOffset: 10,
            tableResizingLimit: 50,
            tableEditButtons: ['tableHeader', 'tableRemove', '|', 'tableRows', 'tableColumns', '-', 'tableCells', 'tableCellBackground', 'tableCellVerticalAlign', 'tableCellHorizontalAlign'],
            videoInsertButtons: ['videoBack', '|', 'videoByURL', 'videoEmbed'],
            videoEditButtons: ['videoReplace', 'videoRemove', '|', 'videoSize'],
            inlineStyles: {
                'Bold': 'font-weight:bold;',
                'Italic': 'font-style:italic;',
                'Underline': 'text-decoration:underline;',
                'Heading 1': 'font-size:24px;',
                'Heading 2': 'font-size:21px;',
            },
            paragraphFormat: {
                N: 'Normal',
                H2: 'Heading 1',
                H3: 'Heading 2',
                H4: 'Heading 3'
            },
            // Массив для форматирования размеров шрифта в теги - загловки
            /*
            sizeToHeader: {
                '18pt': 'h2',
                '16pt': 'h3',
                '14pt': 'h4'
            },
            */
            sizeToHeader: {
                '24px': 'h2',
                '21px': 'h3',
                '19px': 'h4'
            },
            // Маассив для преобразования абзацев в виджеты на соновании их фонового цвета
            templateForWidget: {
                // video: { background: 'lime' , html: '<span class="fr-video fr-fvc fr-dvb fr-draggable" contenteditable="false" draggable="true"><iframe width="640" height="360" src="https://www.youtube.com/embed/s%?wmode=opaque" frameborder="0" allowfullscreen="" class="fr-draggable"></iframe></span>' },
                quote: { background: 'yellow' , html: '<div class="quote-block fr-widget fr-inner fr-breaker">s%</div>' },
                grayBlock: { background: ['lightgrey','silver'] , html: '<div class="gray-text-block fr-widget fr-inner fr-breaker">s%</div>' }
            },
            htmlAllowedEmptyTags: ['textarea', 'a', 'iframe', 'object', 'video', 'style', 'script', '.fa', 'span'],
            htmlAllowedTags: ['p', 'br', 'table','tbody', 'tr', 'td', 'div', 'span', 'a', 'iframe', 'strong', 'b', 'pre', 'i', 'img', 'em', 'u', 's', 'h1', 'h2', 'h3', 'h4', 'ul', 'li', 'ol', 'blockquote', 'time' ],
            lineBreakerTags: ['table', 'hr', 'form','.fr-breaker', '.fr-draggable'],
            lineBreakerOffset: 30,
            pasteAllowLocalImages: false,
            pasteAllowedStyleProps: ['background-color'],
            pasteDeniedTags: ['strong'],
            pasteDeniedAttrs: ['style', 'class'],
            //wordAllowedStyleProps: ['background-color'],
            wordDeniedTags: ['strong'],
            wordPasteModal: false,
            wordPasteKeepFormatting: true,
            useClasses: true,
            emoticonsStep: 8,
            htmlUntouched: true,
            specialCharactersSets: [{
                title: "Punctuation", "char": "&Omega;",
                list: [
                    { 'char': '&laquo;&raquo;', desc: 'LEFT/RIGHT-POINTING DOUBLE ANGLE QUOTATION MARK' },
                    { 'char': '&ndash;', desc: 'EN DASH' },
                    { 'char': '&mdash;', desc: 'EM DASH' }
                ]
            }],
            events:  {
                'image.beforeUpload': function (images) {
                    var self = this;
                    CdnHelper.auth(
                        self.opts.imageUploadURL,
                        [],
                        function (response) {
                            if (response.status !== 'success') {
                                return;
                            }

                            self.opts.requestHeaders = {
                                'Authorization': 'Bearer ' + response.token
                            };
                            self.opts.imageUploadURL = response.uploadUrl;
                            self.opts.proxyDomain = response.staticDomain
                        },
                        false
                    );

                    return images;
                }
            }
        }
    }

    return items[type];
};

EditorHelper.prototype.add = function(selector, options, type) {
    var result = this.getOptions(type);
    if(options !== undefined) {
        for( option in options) {
            result[option] = options[option];
        }
    }

    var editor = new FroalaEditor(selector, result);
    editor.$box.addClass('isolated-styles');

    this.editors.push(editor);
};

EditorHelper.prototype.get = function() {
    return this.editors;
};

EditorHelper.prototype.initIcon = function() {
    FroalaEditor.DefineIconTemplate('iconmoon', '<i class="icon-[NAME]"></i>');
}

EditorHelper.prototype.initCommands = function() {
    //gray_block
    FroalaEditor.DefineIcon('gray_block', {NAME: 'gray_block'});
    FroalaEditor.RegisterCommand('gray_block', {
        title: Yii2Admin.t('editorGrayBlock'),
        focus: false,
        icon: '<i class="icon-bubble-lines3"></i>',
        undo: false,
        refreshAfterCallback: false,
        callback: function () {
            var html = this.opts.templateForWidget.grayBlock.html.replace("s%", Yii2Admin.t('editorGrayBlockText') );
            this.selection.restore();
            this.html.insert(html);
        }
    });
    FroalaEditor.DefineIcon('quote', {NAME: 'quote'});
    FroalaEditor.RegisterCommand('quote', {
        title: Yii2Admin.t('editorQuote'),
        focus: false,
        icon: '<i class="icon-quotes-left"></i>',
        undo: false,
        refreshAfterCallback: false,
        callback: function () {
            var html = this.opts.templateForWidget.quote.html.replace("s%", Yii2Admin.t('editorQuoteText') );
            this.selection.restore();
            this.html.insert(html);
        }
    });
}

EditorHelper.prototype.extendOptions = function (editor, options) {
    for (var option in options) {
        editor.opts[option] = options[option];
    }
}

var EditorHelper = new EditorHelper();

document.addEventListener('DOMContentLoaded', function() {
    EditorHelper.initIcon();
    EditorHelper.initCommands();
})