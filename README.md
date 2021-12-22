# phpBB-External-Links

## Description
With this phpBB extension you can set some parameter at external links and images.
#### Settings in User Control Panel > Board preferences > Edit display options
- Convert plain text links from images to images.
- Convert external images to plain text links.
- Open external links in a new tab/window.- 
#### Settings in Administration Control Panel
- Set the level of the internal domain
- Mark external links.
- Add an external image the URL as caption.

## Requirements
- php 7.3 or higher
- phpBB 3.2.0 or higher

## Installation
Copy the extension to `phpBB3/ext/imcger/externallinks`.
Go to "ACP" > "Customise" > "Extensions Manager" and enable the "External Links" extension.

## Settings
Go to "ACP" > "Extensions" > "External Links settings" and customize "External Links".

## Changelog

### v1.1.2 (20-12-2021)
- Incorrect view in ACP/UCP with English language selection

### v1.1.1 (19-12-2021)
- Code change
- Can change the level of the internal domain

### v1.1.0 (10-12-2021)
- Move some Settings from ACP in the UCP

### v1.0.2 (09-12-2021)
- Bug: Support UCP setting `Display images within posts`

### v1.0.1 (08-12-2021)
- Minor code change

### v1.0.0 (06-12-2021)

## Uninstallation
- Navigate in the ACP to `Customise -> Manage extensions`.
- Click the `Disable` link for External Links.
- To permanently uninstall, click `Delete Data`, then delete the `externallinks` folder from `phpBB3/ext/imcger/`.

## License
[GPLv2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
