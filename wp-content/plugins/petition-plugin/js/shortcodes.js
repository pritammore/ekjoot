/**
 * Create style container custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.style_container', {
        init: function(editor, url) {
            editor.addButton('style_container', {
                title: 'Container',
                image: url + '/tinymce-icons/container-icon.png',
                onclick: function() {
                    editor.insertContent('[container][/container]');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('style_container', tinymce.plugins.style_container);
})();

/**
 * Create spaces custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.spaces', {
        init: function(editor, url) {
            editor.addButton('spaces', {
                title: 'Spaces',
                image: url + '/tinymce-icons/spaces-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Spaces',
                        width: 600,
                        height: 80,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'height',
                                label: 'Height',
                                value: '50'
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[spaces height="' + e.data.height + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('spaces', tinymce.plugins.spaces);
})();


/**
 * Create divier custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.divider', {
        init: function(editor, url) {
            editor.addButton('divider', {
                title: 'Divider',
                image: url + '/tinymce-icons/divider-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Column',
                        width: 600,
                        height: 200,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'listbox',
                                name: 'type',
                                label: 'Type',
                                'values': [
                                    {text: 'Normal', value: 'normal'},
                                    {text: 'Vertical', value: 'vertical'},
                                    {text: 'Horizontal', value: 'horizontal'},
                                    {text: 'Hidden', value: 'hidden'}
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'style',
                                label: 'Style of Divider',
                                'values': [
                                    {text: 'No style', value: 'no'},
                                    {text: 'Fitted', value: 'fitted'},
                                    {text: 'Section', value: 'section'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'invert',
                                label: 'Invert Divider',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Yes', value: 'yes'},
                                ]
                            },
                            {
                                type: 'textbox',
                                name: 'text',
                                label: 'Text Between Divider'
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[divider type="' + e.data.type + '" style="' + e.data.style + '" invert="' + e.data.invert + '" text="' + e.data.text + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('divider', tinymce.plugins.divider);
})();

/**
 * Create button custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.buttons', {
        init: function(editor, url) {
            editor.addButton('buttons', {
                title: 'Button',
                image: url + '/tinymce-icons/buttons-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Button',
                        width: 600,
                        height: 320,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'listbox',
                                name: 'type',
                                label: 'Type',
                                'values': [
                                    {text: 'Square', value: 'square'},
                                    {text: 'Circular', value: 'circular'},
                                    {text: 'Fluid', value: 'fluid'}
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'size',
                                label: 'Size',
                                'values': [
                                    {text: 'Mini', value: 'mini'},
                                    {text: 'Tiny', value: 'tiny'},
                                    {text: 'Small', value: 'small'},
                                    {text: 'Medium', value: 'medium'},
                                    {text: 'Large', value: 'large'},
                                    {text: 'Big', value: 'big'},
                                    {text: 'Huge', value: 'huge'},
                                    {text: 'Massive', value: 'massive'}
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'invert',
                                label: 'Invert Button',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Yes', value: 'yes'},
                                ]
                            },
                            {
                                type: 'colorbox',
                                name: 'color',
                                label: 'Color of Button',
                                value: '#E0E1E2',
                                onaction: createColorPickAction()
                            },
                            {
                                type: 'textbox',
                                name: 'icon',
                                label: 'Icon button'
                            },
                            {
                                type: 'textbox',
                                name: 'text',
                                label: 'Text Button'
                            },
                            {
                                type: 'textbox',
                                name: 'link',
                                label: 'Link'
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[buttons type="' + e.data.type + '" size="' + e.data.size + '" invert="' + e.data.invert + '" color="' + e.data.color + '" icon="' + e.data.icon + '" text="' + e.data.text + '" link="' + e.data.link + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('buttons', tinymce.plugins.buttons);
})();


/**
 * Create title custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.header', {
        init: function(editor, url) {
            editor.addButton('header', {
                title: 'Header',
                image: url + '/tinymce-icons/header-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Header',
                        width: 600,
                        height: 280,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'listbox',
                                name: 'border',
                                label: 'Border',
                                'values': [
                                    {text: 'None', value: 'none'},
                                    {text: 'Short', value: 'short'},
                                    {text: 'Long', value: 'long'},
                                    {text: 'Full', value: 'full'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'align',
                                label: 'Text Align',
                                'values': [
                                    {text: 'Left', value: 'left'},
                                    {text: 'Right', value: 'right'},
                                    {text: 'Center', value: 'center'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'invert',
                                label: 'Invert Title',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Yes', value: 'yes'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'padding',
                                label: 'Padding',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Padded', value: 'padded'},
                                    {text: 'Very Padded', value: 'very padded'},
                                ]
                            },
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title'
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[header border="' + e.data.border + '" align="' + e.data.align + '" invert="' + e.data.invert + '" padding="' + e.data.padding + '" title="' + e.data.title + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('header', tinymce.plugins.header);
})();


/**
 * Create segment custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.segment', {
        init: function(editor, url) {
            editor.addButton('segment', {
                title: 'Segment',
                image: url + '/tinymce-icons/segment-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Segment',
                        width: 600,
                        height: 280,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'listbox',
                                name: 'type',
                                label: 'Type',
                                'values': [
                                    {text: 'Normal', value: 'normal'},
                                    {text: 'Raise', value: 'raised'},
                                    {text: 'Stack', value: 'stacked'},
                                    {text: 'Pile', value: 'piled'},
                                    {text: 'Circular', value: 'circular'},
                                    {text: 'Compact', value: 'compact'},
                                    {text: 'Vertical', value: 'vertical'},
                                    {text: 'Basic', value: 'basic'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'align',
                                label: 'Text Align',
                                'values': [
                                    {text: 'Left', value: 'left'},
                                    {text: 'Right', value: 'right'},
                                    {text: 'Center', value: 'center'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'attach',
                                label: 'Attach',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Top', value: 'top'},
                                    {text: 'Middle', value: 'middle'},
                                    {text: 'Bottom', value: 'bottom'}
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'invert',
                                label: 'Invert Segment',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Yes', value: 'yes'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'padding',
                                label: 'Padding',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Padded', value: 'padded'},
                                    {text: 'Very Padded', value: 'very padded'},
                                ]
                            },
                            {
                                type: 'colorbox',
                                name: 'color',
                                label: 'Color of Segment',
                                value: '#FFFFFF',
                                onaction: createColorPickAction()
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[segment type="' + e.data.type + '" align="' + e.data.align + '" attach="' + e.data.attach + '" invert="' + e.data.invert + '" padding="' + e.data.padding + '" color="' + e.data.color + '"] [/segment]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('segment', tinymce.plugins.segment);
})();


/**
 * Create parallax custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.parallax', {
        init: function(editor, url) {
            editor.addButton('parallax', {
                title: 'Parallax Background',
                image: url + '/tinymce-icons/parallax-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Parallax Background',
                        width: 600,
                        height: 280,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'listbox',
                                name: 'type',
                                label: 'Type',
                                'values': [
                                    {text: 'Image', value: 'image'},
                                    {text: 'Video', value: 'video'}
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'style',
                                label: 'Style',
                                'values': [
                                    {text: 'Scroll', value: 'scroll'},
                                    {text: 'Scale', value: 'scale'},
                                    {text: 'Opacity', value: 'opacity'},
                                    {text: 'Scroll Opacity', value: 'scroll-opacity'},
                                    {text: 'Scale Opacity', value: 'scale-opacity'},
                                ]
                            },
                            {
                                type: 'textbox',
                                name: 'url',
                                label: 'Image or Video URL',
                                value: 'http://'
                            },
                            {
                                type: 'textbox',
                                name: 'height',
                                label: 'Height (px)',
                                value: ''
                            },
                            {
                                type: 'textbox',
                                name: 'speed',
                                label: 'Speed (-1.0 to 2.0)',
                                value: '0.5'
                            },
                            {
                                type: 'colorbox',
                                name: 'color',
                                label: 'Color of Opacity',
                                value: '#000000',
                                onaction: createColorPickAction()
                            },
                            {
                                type: 'listbox',
                                name: 'opacity',
                                label: 'Shadow Opacity Percent',
                                'values': [
                                    {text: '0%', value: '0.0'},
                                    {text: '10%', value: '0.1'},
                                    {text: '20%', value: '0.2'},
                                    {text: '30%', value: '0.3'},                                
                                    {text: '40%', value: '0.4'},
                                    {text: '50%', value: '0.5'},
                                    {text: '60%', value: '0.6'},
                                    {text: '70%', value: '0.7'},
                                    {text: '80%', value: '0.8'},
                                    {text: '90%', value: '0.9'},
                                    {text: '100%', value: '1'}
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[parallax type="' + e.data.type + '" style="' + e.data.style + '" url="' + e.data.url + '" height="' + e.data.height + '" speed="' + e.data.speed + '" color="' + e.data.color + '" opacity="' + e.data.opacity + '"] [/parallax]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('parallax', tinymce.plugins.parallax);
})();

tinymce.init({
    selector: 'textarea',
    plugins: 'colorpicker',
    toolbar: 'parallax'
});

/**
 * Create grid custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.grid', {
        init: function(editor, url) {
            editor.addButton('grid', {
                title: 'Grid',
                image: url + '/tinymce-icons/grid-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Grid',
                        width: 600,
                        height: 250,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'listbox',
                                name: 'align',
                                label: 'Text Align',
                                'values': [
                                    {text: 'Left', value: 'left'},
                                    {text: 'Right', value: 'right'},
                                    {text: 'Center', value: 'center'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'gutter',
                                label: 'Gutters',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Yes', value: 'relaxed'}                               
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'divi',
                                label: 'Dividing',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Yes', value: 'internally celled'}                                
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'equal',
                                label: 'Equal width',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Yes', value: 'equal width'}                                
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'number',
                                label: 'Number of Column',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'One', value: 'one'},
                                    {text: 'Two', value: 'two'},
                                    {text: 'Three', value: 'three'},
                                    {text: 'Four', value: 'four'},
                                    {text: 'Five', value: 'five'},
                                    {text: 'Six', value: 'six'},
                                    {text: 'Seven', value: 'seven'},
                                    {text: 'Eight', value: 'eight'},
                                    {text: 'Nine', value: 'nine'},
                                    {text: 'Ten', value: 'ten'},
                                    {text: 'Twelve', value: 'twelve'},
                                    {text: 'Thirteen', value: 'thirteen'},
                                    {text: 'Fourteen', value: 'fourteen'},
                                    {text: 'Fifteen', value: 'fifteen'},
                                    {text: 'Sixteen', value: 'sixteen'}
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[grid align="' + e.data.align + '" gutter="' + e.data.gutter + '" divi="' + e.data.divi + '" equal="' + e.data.equal + '" number="' + e.data.number + '"] [/grid]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('grid', tinymce.plugins.grid);
})();

/**
 * Create columns custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.column', {
        init: function(editor, url) {
            editor.addButton('column', {
                title: 'Column',
                image: url + '/tinymce-icons/columns-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Column',
                        width: 600,
                        height: 120,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'listbox',
                                name: 'align',
                                label: 'Text Align',
                                'values': [
                                    {text: 'Left', value: 'left'},
                                    {text: 'Right', value: 'right'},
                                    {text: 'Center', value: 'center'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'number',
                                label: 'Number of Column',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'One', value: 'one'},
                                    {text: 'Two', value: 'two'},
                                    {text: 'Three', value: 'three'},
                                    {text: 'Four', value: 'four'},
                                    {text: 'Five', value: 'five'},
                                    {text: 'Six', value: 'six'},
                                    {text: 'Seven', value: 'seven'},
                                    {text: 'Eight', value: 'eight'},
                                    {text: 'Nine', value: 'nine'},
                                    {text: 'Ten', value: 'ten'},
                                    {text: 'Twelve', value: 'twelve'},
                                    {text: 'Thirteen', value: 'thirteen'},
                                    {text: 'Fourteen', value: 'fourteen'},
                                    {text: 'Fifteen', value: 'fifteen'},
                                    {text: 'Sixteen', value: 'sixteen'}
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[column align="' + e.data.align + '" number="' + e.data.number + '"] [/column]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('column', tinymce.plugins.column);
})();

/**
 * Create infomation custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.infomation', {
        init: function(editor, url) {
            editor.addButton('infomation', {
                title: 'Infomations',
                image: url + '/tinymce-icons/infomation-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Infomations Shortcode',
                        width: 600,
                        height: 420,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'infoTitle',
                                label: 'Infomations Title',
                                value: 'Infomations title here'
                            },
                            {
                                type: 'listbox',
                                name: 'show',
                                label: 'Infomations Number',
                                'values': [
                                    { text : '2', value : '2' },
                                    { text : '3', value : '3' },
                                    { text : '4', value : '4' }
                                ]
                            },
                            {
                                type: 'colorbox',
                                name: 'color',
                                label: 'Color of Header',
                                value: '#000000',
                                onaction: createColorPickAction()
                            },
                            {
                                type: 'textbox',
                                name: 'firstinfoIcon',
                                label: '1st info Icon',
                                value: 'empty star'
                            },
                            {
                                type: 'textbox',
                                name: 'firstinfoTitle',
                                label: '1st info Title',
                                value: '1st info title here'
                            },
                            {
                                type: 'textbox',
                                name: 'firstinfoText',
                                label: '1st info Text',
                                value: '1st info text here'
                            },
                            {
                                type: 'textbox',
                                name: 'firstinfoLink',
                                label: '1st info Link',
                                value: 'http://'
                            },
                            {
                                type: 'textbox',
                                name: 'secondinfoIcon',
                                label: '2nd info Icon',
                                value: 'empty star'
                            },
                            {
                                type: 'textbox',
                                name: 'secondinfoTitle',
                                label: '2nd info Title',
                                value: '2nd info title here'
                            },
                            {
                                type: 'textbox',
                                name: 'secondinfoText',
                                label: '2nd info Text',
                                value: '2nd info text here'
                            },
                            {
                                type: 'textbox',
                                name: 'secondinfoLink',
                                label: '2nd info Link',
                                value: 'http://'
                            },
                            {
                                type: 'textbox',
                                name: 'thirdinfoIcon',
                                label: '3rd info Icon',
                                value: 'empty star'
                            },
                            {
                                type: 'textbox',
                                name: 'thirdinfoTitle',
                                label: '3rd info Title',
                                value: '3rd info title here'
                            },
                            {
                                type: 'textbox',
                                name: 'thirdinfoText',
                                label: '3rd info Text',
                                value: '3rd info text here'
                            },
                            {
                                type: 'textbox',
                                name: 'thirdinfoLink',
                                label: '3rd info Link',
                                value: 'http://'
                            },
                            {
                                type: 'textbox',
                                name: 'fourthinfoIcon',
                                label: '4th info Icon',
                                value: 'empty star'
                            },
                            {
                                type: 'textbox',
                                name: 'fourthinfoTitle',
                                label: '4th info Title',
                                value: '4th info title here'
                            },
                            {
                                type: 'textbox',
                                name: 'fourthinfoText',
                                label: '4th info Text',
                                value: '4th info text here'
                            },
                            {
                                type: 'textbox',
                                name: 'fourthinfoLink',
                                label: '4th info Link',
                                value: 'http://'
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[infomation stitle="' + e.data.infoTitle + 
                                '" show="' + e.data.show + 
                                '" color="' + e.data.color +
                                '" s1icon="' + e.data.firstinfoIcon + 
                                '" s1title="' + e.data.firstinfoTitle + 
                                '" s1text="' + e.data.firstinfoText + 
                                '" s1link="' + e.data.firstinfoLink + 
                                '" s2icon="' + e.data.secondinfoIcon + 
                                '" s2title="' + e.data.secondinfoTitle + 
                                '" s2text="' + e.data.secondinfoText + 
                                '" s2link="' + e.data.secondinfoLink + 
                                '" s3icon="' + e.data.thirdinfoIcon + 
                                '" s3title="' + e.data.thirdinfoTitle + 
                                '" s3text="' + e.data.thirdinfoText + 
                                '" s3link="' + e.data.thirdinfoLink + 
                                '" s4icon="' + e.data.fourthinfoIcon + 
                                '" s4title="' + e.data.fourthinfoTitle + 
                                '" s4text="' + e.data.fourthinfoText + 
                                '" s4link="' + e.data.fourthinfoLink + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('infomation', tinymce.plugins.infomation);
})();


/**
 * Create icon box shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.iconbox', {
        init: function(editor, url) {
            editor.addButton('iconbox', {
                title: 'Icon Box',
                image: url + '/tinymce-icons/iconbox-icon.png',
                onclick: function() {
                    editor.windowManager.open( {
                        title: 'Insert Icon Box Shortcode',
                        width: 600,
                        height: 420,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'icon',
                                label: 'Icon (icon font or URL)',
                                value: 'empty star'
                            },
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Title Here'
                            },
                            {
                                type: 'textbox',
                                name: 'description',
                                label: 'Description',
                                value: 'Description Here'
                            },
                            {
                                type: 'textbox',
                                name: 'link',
                                label: 'Link',
                                value: '#'
                            },
                            {
                                type: 'textbox',
                                name: 'size',
                                label: 'Size of Icon',
                                value: '110'
                            },
                            {
                                type: 'listbox',
                                name: 'type',
                                label: 'Type',
                                'values': [
                                    {text: 'Normal', value: 'normal'},
                                    {text: 'Raise', value: 'raised'},
                                    {text: 'Stack', value: 'stacked'},
                                    {text: 'Pile', value: 'piled'},
                                    {text: 'Circular', value: 'circular'},
                                    {text: 'Compact', value: 'compact'},
                                    {text: 'Vertical', value: 'vertical'},
                                    {text: 'Basic', value: 'basic'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'style',
                                label: 'style',
                                'values': [
                                    {text: 'Horizontal', value: 'horizontal'},
                                    {text: 'Vertical', value: 'vertical'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'align',
                                label: 'Text Align',
                                'values': [
                                    {text: 'Left', value: 'left'},
                                    {text: 'Right', value: 'right'},
                                    {text: 'Center', value: 'center'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'invert',
                                label: 'Invert Box',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Yes', value: 'yes'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'padding',
                                label: 'Padding',
                                'values': [
                                    {text: 'No', value: 'no'},
                                    {text: 'Padded', value: 'padded'},
                                    {text: 'Very Padded', value: 'very padded'},
                                ]
                            },
                            {
                                type: 'colorbox',
                                name: 'color',
                                label: 'Color',
                                value: '#FFFFFF',
                                onaction: createColorPickAction()
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[iconbox icon="' + e.data.icon + '" title="' + e.data.title + '" description="' + e.data.description + '" link="' + e.data.link + '" size="' + e.data.size + '" type="' + e.data.type + '" style="' + e.data.style + '" align="' + e.data.align + '" invert="' + e.data.invert + '" padding="' + e.data.padding + '" color="' + e.data.color + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('iconbox', tinymce.plugins.iconbox);
})();


/**
 * Create recent properties custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.recent_petitions', {
        init: function(editor, url) {
            editor.addButton('recent_petitions', {
                title: 'Recent Petitions',
                image: url + '/tinymce-icons/recent-petitions-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Recent Petitions Shortcode',
                        width: 600,
                        height: 240,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Recent Petitions'
                            },
                            {
                                type: 'textbox',
                                name: 'show',
                                label: 'Number of Petitions',
                                value: '4'
                            },
                            {
                                type: 'listbox',
                                name: 'style',
                                label: 'View style',
                                'values': [
                                    { text : 'List', value : 'list' },
                                    { text : 'Grid', value : 'grid' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'carousel',
                                label: 'Carousel mode',
                                'values': [
                                    { text : 'No', value : 'no' },
                                    { text : 'Yes', value : 'yes' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'column',
                                label: 'Column',
                                'values': [
                                    { text : '1', value : 'one' },
                                    { text : '2', value : 'two' },
                                    { text : '3', value : 'three' },
                                    { text : '4', value : 'four' },
                                    { text : '5', value : 'five' }
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[recent_petitions title="' + e.data.title + '" show="' + e.data.show + '" style="' + e.data.style + '" carousel="' + e.data.carousel + '" column="' + e.data.column + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('recent_petitions', tinymce.plugins.recent_petitions);
})();

/**
 * Create featured petition custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.featured_petitions', {
        init: function(editor, url) {
            editor.addButton('featured_petitions', {
                title: 'Featured Petitions',
                image: url + '/tinymce-icons/featured-petitions-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Featured Petitions Shortcode',
                        width: 600,
                        height: 240,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Featured Petitions'
                            },
                            {
                                type: 'textbox',
                                name: 'show',
                                label: 'Number of Petitions',
                                value: '4'
                            },
                            {
                                type: 'listbox',
                                name: 'style',
                                label: 'View style',
                                'values': [
                                    { text : 'List', value : 'list' },
                                    { text : 'Grid', value : 'grid' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'carousel',
                                label: 'Carousel mode',
                                'values': [
                                    { text : 'No', value : 'no' },
                                    { text : 'Yes', value : 'yes' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'column',
                                label: 'Column',
                                'values': [
                                    { text : '1', value : 'one' },
                                    { text : '2', value : 'two' },
                                    { text : '3', value : 'three' },
                                    { text : '4', value : 'four' },
                                    { text : '5', value : 'five' }
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[featured_petitions title="' + e.data.title + '" show="' + e.data.show + '" style="' + e.data.style + '" carousel="' + e.data.carousel + '" column="' + e.data.column + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('featured_petitions', tinymce.plugins.featured_petitions);
})();


/**
 * Create recent victory custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.recent_victory', {
        init: function(editor, url) {
            editor.addButton('recent_victory', {
                title: 'Recent Victory Petitions',
                image: url + '/tinymce-icons/recent-victory-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Recent Victory Petitions Shortcode',
                        width: 600,
                        height: 240,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Recent Victory Petitions'
                            },
                            {
                                type: 'textbox',
                                name: 'show',
                                label: 'Number of Petitions',
                                value: '4'
                            },
                            {
                                type: 'listbox',
                                name: 'style',
                                label: 'View style',
                                'values': [
                                    { text : 'List', value : 'list' },
                                    { text : 'Grid', value : 'grid' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'carousel',
                                label: 'Carousel mode',
                                'values': [
                                    { text : 'No', value : 'no' },
                                    { text : 'Yes', value : 'yes' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'column',
                                label: 'Column',
                                'values': [
                                    { text : '1', value : 'one' },
                                    { text : '2', value : 'two' },
                                    { text : '3', value : 'three' },
                                    { text : '4', value : 'four' },
                                    { text : '5', value : 'five' }
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[recent_victory title="' + e.data.title + '" show="' + e.data.show + '" style="' + e.data.style + '" carousel="' + e.data.carousel + '" column="' + e.data.column + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('recent_victory', tinymce.plugins.recent_victory);
})();

/**
 * Create featured victory petition custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.featured_victory', {
        init: function(editor, url) {
            editor.addButton('featured_victory', {
                title: 'Featured Victory Petitions',
                image: url + '/tinymce-icons/featured-victory-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Featured Victory Petitions Shortcode',
                        width: 600,
                        height: 240,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Featured Victory Petitions'
                            },
                            {
                                type: 'textbox',
                                name: 'show',
                                label: 'Number of Petitions',
                                value: '4'
                            },
                            {
                                type: 'listbox',
                                name: 'style',
                                label: 'View style',
                                'values': [
                                    { text : 'List', value : 'list' },
                                    { text : 'Grid', value : 'grid' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'carousel',
                                label: 'Carousel mode',
                                'values': [
                                    { text : 'No', value : 'no' },
                                    { text : 'Yes', value : 'yes' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'column',
                                label: 'Column',
                                'values': [
                                    { text : '1', value : 'one' },
                                    { text : '2', value : 'two' },
                                    { text : '3', value : 'three' },
                                    { text : '4', value : 'four' },
                                    { text : '5', value : 'five' }
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[featured_victory title="' + e.data.title + '" show="' + e.data.show + '" style="' + e.data.style + '" carousel="' + e.data.carousel + '" column="' + e.data.column + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('featured_victory', tinymce.plugins.featured_victory);
})();

/**
 * Create featured agents custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.team', {
        init: function(editor, url) {
            editor.addButton('team', {
                title: 'Team',
                image: url + '/tinymce-icons/team-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Team Shortcode',
                        width: 600,
                        height: 100,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Our Team'
                            },
                            {
                                type: 'textbox',
                                name: 'show',
                                label: 'Number of Member',
                                value: '4'
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[team title="' + e.data.title + '" show="' + e.data.show + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('team', tinymce.plugins.team);
})();

/**
 * Create testimonials custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.testimonials', {
        init: function(editor, url) {
            editor.addButton('testimonials', {
                title: 'Testimonials',
                image: url + '/tinymce-icons/testimonials-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Testimonials Shortcode',
                        width: 600,
                        height: 160,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'listbox',
                                name: 'type',
                                label: 'Type',
                                'values': [
                                    { text : 'Horizontal', value : 'horizontal' },
                                    { text : 'Vertical', value : 'vertical' }
                                ]
                            },
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Testimonials'
                            },
                            {
                                type: 'textbox',
                                name: 'show',
                                label: 'Number of Testimonials',
                                value: '3'
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[testimonials type="' + e.data.type + '" title="' + e.data.title + '" show="' + e.data.show + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('testimonials', tinymce.plugins.testimonials);
})();

/**
 * Create latest blog posts custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.latest_posts', {
        init: function(editor, url) {
            editor.addButton('latest_posts', {
                title: 'Latest Blog Posts',
                image: url + '/tinymce-icons/latest-posts-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Latest Blog Posts Shortcode',
                        width: 600,
                        height: 200,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Latest Blog Posts'
                            },
                            {
                                type: 'textbox',
                                name: 'show',
                                label: 'Number of posts',
                                value: '4'
                            },
                            {
                                type: 'listbox',
                                name: 'carousel',
                                label: 'Carousel mode',
                                'values': [
                                    { text : 'No', value : 'no' },
                                    { text : 'Yes', value : 'yes' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'column',
                                label: 'Column',
                                'values': [
                                    { text : '1', value : 'one' },
                                    { text : '2', value : 'two' },
                                    { text : '3', value : 'three' },
                                    { text : '4', value : 'four' },
                                    { text : '5', value : 'five' }
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[latest_posts title="' + e.data.title + '" show="' + e.data.show + '" carousel="' + e.data.carousel + '" column="' + e.data.column + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('latest_posts', tinymce.plugins.latest_posts);
})();

/**
 * Create featured blog posts custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.featured_posts', {
        init: function(editor, url) {
            editor.addButton('featured_posts', {
                title: 'Featured Blog Posts',
                image: url + '/tinymce-icons/featured-posts-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Featured Blog Posts Shortcode',
                        width: 600,
                        height: 200,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Featured Blog Posts'
                            },
                            {
                                type: 'textbox',
                                name: 'show',
                                label: 'Number of posts',
                                value: '4'
                            },
                            {
                                type: 'listbox',
                                name: 'carousel',
                                label: 'Carousel mode',
                                'values': [
                                    { text : 'No', value : 'no' },
                                    { text : 'Yes', value : 'yes' }
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'column',
                                label: 'Column',
                                'values': [
                                    { text : '1', value : 'one' },
                                    { text : '2', value : 'two' },
                                    { text : '3', value : 'three' },
                                    { text : '4', value : 'four' },
                                    { text : '5', value : 'five' }
                                ]
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[featured_posts title="' + e.data.title + '" show="' + e.data.show + '" carousel="' + e.data.carousel + '" column="' + e.data.column + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('featured_posts', tinymce.plugins.featured_posts);
})();


/**
 * Create featured blog posts custom shortcode button
 */
(function() {
    tinymce.create('tinymce.plugins.category', {
        init: function(editor, url) {
            editor.addButton('category', {
                title: 'Petition Categories',
                image: url + '/tinymce-icons/category-icon.png',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'Insert Petition Categories or Topics',
                        width: 600,
                        height: 200,
                        scrollbars: true,
                        autoScroll: true,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: 'Title',
                                value: 'Categories'
                            },
                            {
                                type: 'listbox',
                                name: 'type',
                                label: 'Type',
                                'values': [
                                    { text : 'Category', value : 'category' },
                                    { text : 'Topics', value : 'topics' }
                                ]
                            },
                            {
                                type: 'textbox',
                                name: 'slugs',
                                label: 'Slug or ID (separate by commas)',
                                value: ''
                            }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[category title="' + e.data.title + '" type="' + e.data.type + '" slugs="' + e.data.slugs + '"]');
                        }
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('category', tinymce.plugins.category);
})();


// Taken from core plugins
var editor = tinymce.activeEditor;

function createColorPickAction() {
    var colorPickerCallback = editor.settings.color_picker_callback;

    if (colorPickerCallback) {
        return function() {
            var self = this;

            colorPickerCallback.call(
                editor,
                function(value) {
                    self.value(value).fire('change');
                },
                self.value()
            );
        };
    }
}