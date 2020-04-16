function EditorHelper() {
    this.editors = [];
    this.config = {
        default: {
            events:  {
                'contentChanged': function () {
                    yii2admin.formChanged=true;
                    var $form = $(this.$oel).closest('form');
                    if(typeof $form.attr('data-validate-attribute-form') !== 'undefined') {
                        yii2admin.activeForm.validateAttribute.run($(this.$oel));
                    }
                },
            }
        },
        basic: {
            enter : FroalaEditor.ENTER_BR,
            attribution : false,
            heightMin: 300,
            toolbarSticky: true,
            toolbarInline: false,
            editorClass: 'editor-default contentable',
            toolbarButtons: [
                'bold', 'italic', 'underline', '|', 'insertLink'
            ],
            linkEditButtons: ['linkOpen', 'linkEdit', 'linkRemove'],
            linkInsertButtons: ['linkBack'],
            quickInsertTags: [''],
            htmlAllowedTags: ['a', 'ul', 'ol', 'li', 'br'],
            events:  {
                'contentChanged': function () {
                    yii2admin.formChanged=true;
                    var $form = $(this.$oel).closest('form');
                    if(typeof $form.attr('data-validate-attribute-form') !== 'undefined') {
                        yii2admin.activeForm.validateAttribute.run($(this.$oel));
                    }
                },
            }
        }
    }
}

EditorHelper.prototype.get = function() {
    return this.editors;
};

EditorHelper.prototype.add = function(selector, type) {
    var editor = new FroalaEditor(selector, this.config[type]);
    editor.$box.addClass('isolated-styles');
    editor.$el.addClass('content-body');
    this.editors.push(editor);
};

EditorHelper.prototype.extendConfig = function(type, options) {
    this.config[type] = _.merge(options, this.config[type]);
};

EditorHelper.prototype.setConfig = function(type, options) {
    this.config[type] = options;
};

EditorHelper.prototype.initIcon = function() {
    FroalaEditor.DefineIconTemplate('iconmoon', '<i class="icon-[NAME]"></i>');
};

var editorHelper = new EditorHelper();

document.addEventListener('DOMContentLoaded', function() {
    editorHelper.initIcon();
});