# WordPress Mercury Parser
Create WordPress posts using the [Mercury Parser API](https://github.com/postlight/mercury-parser). Simply provide URLs to this plugin, and have them reconstructed within your own WordPress CMS (or dashboard?).

![example](/demo.gif)

## Installation
1. Download the zip file of this repo [here](https://github.com/postlight/wp-mercury-parser/archive/master.zip).
2. Follow the instructions [here](https://wordpress.org/support/article/managing-plugins/#installing-plugins) to install the plugin.
3. Verify the installation by checking the installed plugins on the WordPress dashboard.
4. If desired, the plugin has its own settings page where you can change the Mercury Parser API endpoint.

## Instructions
The WordPress Mercury Parser allows for creating WP posts by importing content from other websites using the Mercury Parser API. The process is
simple and straightforward:
  1. On the plugin page, select the text box and enter up to 5 URLs per batch. Malformed or duplicate URLs will be ignored.
  2. For each URL, the plugin will then trigger the Mercury Parser to parse through each of the desired pages, and then have them reconstructed in WordPress.
  3. Pages that were successfully parsed will appear below, each previewable and editable.

## Roadmap
- Select or bulk create posts after preview.
- Import logging with ability to update posts.
- UTF support for imported URLs.

## Posts Fields

| Field         | Field Type   
| ------------- |:-------------:|
| Title      | Default
| Content      | Default 
| Excerpt | Default
| Featured Image | Default
| URL | Custom Field
| Source | Custom Field
| Direction | Custom Field 
