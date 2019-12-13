import Quill from 'quill/core'

import Toolbar from 'quill/modules/toolbar'
import Snow from 'quill/themes/snow'

import Bold from 'quill/formats/bold'
import Italic from 'quill/formats/italic'
import Header from 'quill/formats/header'
import Underline from 'quill/formats/underline'
import Link from 'quill/formats/link'
import List, { ListItem } from 'quill/formats/list'
import Blockquote from 'quill/formats/blockquote'
import CodeBlock from 'quill/formats/code'
import { SizeClass } from 'quill/formats/size'
import { AlignClass } from 'quill/formats/align'
import { DirectionClass } from 'quill/formats/direction'
import { ColorClass } from 'quill/formats/color'
import { BackgroundClass } from 'quill/formats/background'

import Image from 'quill/formats/image'
import { ImageDrop } from 'quill-image-drop-module'
import ImageResize from 'quill-image-resize'

//import Emoji from 'quill-emoji'
 
Quill.register({
    'modules/toolbar': Toolbar,
    'modules/imageDrop': ImageDrop,
    'modules/imageResize': ImageResize,
    //'modules/emoji-toolbar': Emoji.ToolbarEmoji,
    //'modules/emoji-shortname': Emoji.ShortNameEmoji,
    //'modules/emoji-textarea': Emoji.TextAreaEmoji,
    'themes/snow': Snow,
    'formats/size': SizeClass,
    'formats/codeblock': CodeBlock,
    'formats/bold': Bold,
    'formats/italic': Italic,
    'formats/underline': Underline,
    'formats/blockquote': Blockquote,
    'formats/link': Link,
    'formats/list': List,
    'formats/list/item': ListItem,
    'formats/header': Header,
    'formats/align': AlignClass,
    'formats/direction': DirectionClass,
    'formats/color': ColorClass,
    'formats/background': BackgroundClass,
    'formats/image': Image
})

export default Quill