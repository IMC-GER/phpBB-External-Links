# phpBB-External-Links

## Description
With this extension it is possible to influence the display of links and pictures. Some settings are available in the "User Control Panel". This allows the user to decide for himself what is more important to him. Secure data transfer, comfortable display or fast loading times of the forum page.

In the Administration Control Panel, the administrator chooses which domain is to be recognised as his own domain. The subdomains underneath are included in each case.
External links and images can be identified by adding the source as a caption to the images and by adding a symbol to links.
He can specify the maximum size of images in pixels that may be embedded in a post. Larger images are automatically changed to a text link.
The administrator can use the forum authorisation system to make external links and images in posts inaccessible to users. The user will instead be shown the message "You do not have sufficient permission to view this link".

In the User Control Panel, the user can instruct the board to open external links in a new tab or window.
For faster loading times, the user can converted all external images to a text link.
To view all images quickly, the user can have all images that are inserted as text links displayed as images in the posts.
For more data security, he can convert insecurely transmitted images (http: connection) into a text link.

#### Settings in User Control Panel > Board preferences > Edit display options
- Convert plain text links from images to images.
- Convert external images to plain text links.
- Open external links in a new tab/window.
- Show insecurely transferred images as link.

#### Settings in Administration Control Panel
- Set the level of the internal domain
- Mark external links.
- Added an external image the URL as caption.
- Improved recognition of links to images
- Image dimensions for display image as an inline text link if image is larger
- Set defauts for UCP or overwrite User settings

#### Permission
- Added forum permission: "Can see links in posts."

## Screenshots
- [ACP](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/externallinks/de/acp.jpg)
- [UCP - Edit display options](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/externallinks/de/ucp.jpg)
- [Forum Based Permissions](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/externallinks/de/permission.jpg)
- [Marked links](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/externallinks/de/post_image.jpg)
- [Post - Images to big](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/externallinks/de/post_error.jpg)
- [Post - No Permissions](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/externallinks/de/post_permission.jpg)

## Requirements
- php 5.4.7 or higher
- phpBB 3.2.4 or higher

## Installation
Copy the extension to `phpBB3/ext/imcger/externallinks`.
Go to "ACP" > "Customise" > "Manage extensions" and enable the "External Links" extension.

# Update
- Navigate in the ACP to `Customise -> Manage extensions`.
- Click the `Disable` link for "External Links".
- Delete the `externallinks` folder from `phpBB3/ext/imcger/`.
- Copy the extension to `phpBB3/ext/imcger/externallinks`.
- Go to "ACP" > "Customise" > "Extensions Manager" and enable the "External Links" extension.

## Settings
Go to "ACP" > "Extensions" > "External Links settings" and customize "External Links".

## Update instructions:
- Go to "ACP" > "Customise" > "Manage extensions" and disable the "External Links" extension.
- Delete all files of the extension from `phpBB3/ext/imcger/externallinks`.
- Upload all new files to the same locations
- Go to "ACP" > "Customise" > "Manage extensions" and enable the "External Links" extension.

## Changelog

### v1.5.2 (05-03-2023)
- Revised ACP templates
  - Removed JS in template
  - Added `confirm_box()` for confirm user settings
  - Changed from radio button to toggle
- Changed ext. link sign from `Font Awesome` to svg graphic
- Changed in php code to short array syntax

### v1.5.1 (21-12-2022)
- Fixed typo
- Changed to TWIG syntax
- Changed PHP max to v8.2
- Update language variable
- Update check system requirement

### v1.5.0 (16-11-2022)
- Added ACP panel for affect user settings
- Change requirements

### v1.4.6 (16-10-2022)
- Added ACP setting for improved image recognition

### v1.4.5 (09-10-2022)
- Added title tag to caption

### v1.4.4 (07-09-2022)
- Bug: Parser remove line breaks

### v1.4.3 (06-09-2022)
- Improved image recognition
- Code changes

### v1.4.2 (08-08-2022)
- Fixed a typo

### v1.4.1 (08-08-2022)
- Bug: Don't find the image to make it inaccessible in the message

### v1.4.0 (07-08-2022)
- Bug: Force default board language
- Display external image as an inline text link if image to large
- Added version check
- Added check system requirement
- Added Controller for ACP template

### v1.3.0 (16-04-2022)
- Bug: Don't show external image whith subline
- Bug: Don't show internal image
- Deprecated function removed
- Added forum permission

### v1.2.3 (09-04-2022)
- remove JavaScript

### v1.2.2 (06-04-2022)
- support for phpBB-Fancybox

### v1.2.1 (19-03-2022)
- Cleanup Code

### v1.2.0 (25-12-2021)
- Code changes
- Show insecurely transferred images (http://) as link.

### v1.1.2 (20-12-2021)
- Incorrect view in ACP/UCP with English language selection

### v1.1.1 (19-12-2021)
- Code changes
- Can change the level of the internal domain

### v1.1.0 (10-12-2021)
- Move some Settings from ACP in the UCP

### v1.0.2 (09-12-2021)
- Bug: Support UCP setting `Display images within posts`

### v1.0.1 (08-12-2021)
- Minor code changes

### v1.0.0 (06-12-2021)

## Uninstallation
- Navigate in the ACP to `Customise -> Manage extensions`.
- Click the `Disable` link for External Links.
- To permanently uninstall, click `Delete Data`, then delete the `externallinks` folder from `phpBB3/ext/imcger/`.

## License
[GPLv2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
