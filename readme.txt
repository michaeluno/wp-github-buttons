=== WP GitHub Buttons ===
Contributors:       Michael Uno, miunosoft
Donate link:        http://en.michaeluno.jp/donate
Tags:               button, buttons, widget, widgets, shortcode, github, icon, icons, octicon, octicons
Requires at least:  3.3
Tested up to:       4.1.1
Stable tag:         1.0.0
License:            GPLv2 or later
License URI:        http://www.gnu.org/licenses/gpl-2.0.html

Displays GitHub buttons.

== Description ==

Displays GitHub buttons with your proffered octicon.

<h4>Features</h4>
- **Widget** 
- **Shortcode** 

== Installation ==

= Install = 

1. Upload **`wp-github-buttons.php`** and other files compressed in the zip folder to the **`/wp-content/plugins/`** directory.,
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Other Notes ==

== Frequently Asked Questions ==
<h4>Shortcode Slug<h4>

`wp_github_button`

`
[wp_github_button]
`

<h4>Shortcode Parameters</h4>

- `account` - the account name. For example, For example, in the repository url `https://github.com/michaeluno/wp-github-buttons` it will be `michaeluno`.
- `repository` - the repository slug. For example, in the repository url `https://github.com/michaeluno/wp-github-buttons` it will be `wp-github-buttons`.
- `show_count` - `1` or `0` set 1 to show the count.
- `type` - either of the followings or set none for a custom link.
    - `.fork`  - the fork button.
    - `.follow` - the follow button.
    - `.star` - the stargazer button.
    - `.issue` - the issue button.
        
- `data_style` - `default` or `mega` For a large button, set `mega`.
- `data_text` - the button label.

`
[wp_github_button type='.star' account='michaeluno' repository='wp-github-buttons' show_count=1 data_text='Fork Me!' data_style='mega']
`    

- `data_icon` - your preferred octicon. e.g. `octicon-gift`

`
[wp_github_button href='https://wordpress.org' data_icon='octicon-gift' data_text='Gift' data_style='mega']
`    

== Screenshots ==

1. ***Widget Form***
2. ***Front-end***

== Changelog ==

= 1.0.0 - 2015/03/01 =
- Released.
