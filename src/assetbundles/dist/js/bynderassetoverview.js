/**
 * Bynder UCV plugin for Craft CMS 5.x
 *
 * CraftBynderDamField Field JS
 *
 * @author    Bynder
 * @copyright Copyright (c) 2024 Loqus
 * @link      https://www.loqus.nl
 * @package   byndercraftcms
 */

var volume = "";
(function ($) {
    Craft.CraftBynderAssetSelector = Garnish.Base.extend(
        {
            init: function (options) {
                if(window.location.pathname.indexOf("/edit/") == -1){
                    var currentvolume = $(".sidebar .sel");
                    var folder = currentvolume.data("folder-id");
                    var volumehandle = currentvolume.data("volume-handle");
                    $("#action-buttons").prepend('<button type="button" title="Add asset from bynder" class="btn bynder hidden hairline-dark" style="position: relative; overflow: hidden;vertical-align: bottom; margin-right:8px;"><img height="20" width="20" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iMzAiIHZpZXdCb3g9IjAgMCA0MCAzMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzI5MDdfMzQ1OCkiPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTIzLjMgMy4yMzQwMkwxMC41MTcgMTUuOTQyTDYuODYzIDEyLjMwNUM2LjIzMDg1IDExLjYwMzYgNS44ODUzNSAxMC42OTAyIDUuODk1IDkuNzQ2MDJDNS44OTUgNy42MTkwMiA3LjYxNCA1LjkyMjAyIDkuNzY2IDUuOTIyMDJDMTAuNzM0IDUuOTIyMDIgMTEuNTg2IDYuMjUzMDIgMTIuMzA5IDYuODcyMDJDMTIuNTM5IDcuMDcyMDIgMTMuMTg5IDcuNzM0MDIgMTMuMTg5IDcuNzM0MDJMMTcuMjM1IDMuNzA5MDJMMTYuMDY1IDIuNTQ0MDJDMTQuMzc0IDAuOTUwMDE5IDEyLjA2MiAxLjkxOTQ3ZS0wNSA5LjUzNCAxLjkxOTQ3ZS0wNUM0LjI3NiAxLjkxOTQ3ZS0wNSAwIDQuMjQwMDIgMCA5LjQ3MzAyQzAgMTEuODczIDAuOTEgMTQuMTAyIDIuMzQgMTUuNzRMMTAuNTQ1IDIzLjkzNEwyNy42OTIgNi44NzAwMkMyOC4zOTM4IDYuMjQwNDEgMjkuMzA2MiA1Ljg5NjggMzAuMjQ5IDUuOTA3MDJDMzAuNzU0NiA1LjkwNjM2IDMxLjI1NTQgNi4wMDU2MSAzMS43MjI1IDYuMTk5MDZDMzIuMTg5NyA2LjM5MjUyIDMyLjYxNCA2LjY3NjM3IDMyLjk3MTEgNy4wMzQzMkMzMy4zMjgyIDcuMzkyMjYgMzMuNjExIDcuODE3MjMgMzMuODAzNCA4LjI4NDgyQzMzLjk5NTggOC43NTI0MiAzNC4wOTM4IDkuMjUzNDEgMzQuMDkyIDkuNzU5MDJDMzQuMDkyIDEwLjcyMyAzMy43NTkgMTEuNTg1IDMzLjEyNCAxMi4yODlMMjEuNzI2IDIzLjYzMkMyMS4yOTMgMjQuMDkyIDIwLjY3MiAyNC4zMzYgMTkuOTkzIDI0LjM1MUMxOS42NzIzIDI0LjM1MjQgMTkuMzU0OSAyNC4yODY2IDE5LjA2MTIgMjQuMTU3OEMxOC43Njc1IDI0LjAyODkgMTguNTA0MSAyMy44NCAxOC4yODggMjMuNjAzTDE3LjQzNiAyMi43NTVMMTMuNDA2IDI2Ljc2NUwxNC4yMjkgMjcuNTcxQzE0Ljk4NTYgMjguMzM5NCAxNS44ODczIDI4Ljk0OTkgMTYuODgxOCAyOS4zNjY4QzE3Ljg3NjIgMjkuNzgzOCAxOC45NDM2IDI5Ljk5OSAyMC4wMjIgMzBDMjIuMjc1IDMwIDI0LjI5OCAyOS4wOCAyNS43NzEgMjcuNTg1TDM3LjY0NSAxNS43NEMzOS4xNjI4IDE0LjAwNSAzOS45OTk2IDExLjc3ODIgNDAgOS40NzMwMkM0MCA0LjI0MDAyIDM1LjcyNCAxLjkxOTQ3ZS0wNSAzMC40NjYgMS45MTk0N2UtMDVDMjkuMTEwMSAtMC4wMDI3MDQzNSAyNy43NjkyIDAuMjg0NDM2IDI2LjUzMzMgMC44NDIxOTVDMjUuMjk3NCAxLjM5OTk1IDI0LjE5NSAyLjIxNTQ1IDIzLjMgMy4yMzQwMloiIGZpbGw9IiMxMjZERkUiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yOTA3XzM0NTgiPgo8cmVjdCB3aWR0aD0iNDAiIGhlaWdodD0iMzAiIGZpbGw9IndoaXRlIi8+CjwvY2xpcFBhdGg+CjwvZGVmcz4KPC9zdmc+Cg=="></button>');
                    var trigger = $(".bynder");
                    var datLocationFound = false;
                    var mediaIdFound = false;
                    $("#sidebar li a").on('click',function(){
                        datLocationFound = false;
                        mediaIdFound = false;
                        $(".bynder").addClass("hidden");
                        currentvolume = $(".sidebar .sel");
                        folder = currentvolume.data("folder-id");
                        volumehandle = currentvolume.data("volume-handle");
                        colOptsStr = currentvolume.attr("data-table-col-opts");
                        colOptsStr = colOptsStr.replace(/&quot;/g, '"');
                        colOpts = JSON.parse(colOptsStr);
                        $.each(colOpts, function(index, option) {
                            if (option.label === 'datLocation') {
                                datLocationFound = true;
                            }
                            if (option.label === 'mediaId') {
                                mediaIdFound = true;
                            }
                        });
                        if(datLocationFound && mediaIdFound){
                            $(".bynder").removeClass("hidden");
                        }else{
                            $(".bynder").addClass("hidden");
                        }
                    });
                    colOptsStr = currentvolume.attr("data-table-col-opts");
                    colOptsStr = colOptsStr.replace(/&quot;/g, '"');
                    colOpts = JSON.parse(colOptsStr);
                    $.each(colOpts, function(index, option) {
                       
                        if (option.label === 'datLocation') {
                            datLocationFound = true;
                        }
                        if (option.label === 'mediaId') {
                            mediaIdFound = true;
                        }
                        
                    });
                    if(datLocationFound && mediaIdFound){
                        $(".bynder").removeClass("hidden");
                    }else{
                        $(".bynder").addClass("hidden");
                    }
                    var volumeforreindex = 0;
                    $(trigger).click(function(){
                        BynderCompactView.open({
                            language: options.language,
                            portal: {
                                url: options.portalurl
                            },
                            theme: {
                                colorButtonPrimary: "#126DFE"
                            },
                            assetTypes: ["image"],
                            mode: options.selecttype,
                            onSuccess: function(assets) {
                                var objarray=[];
                                for (let i = 0; i < assets.length; i++) {
                                    var asset = assets[i];
                                    if (asset.files.transformBaseUrl === undefined) {
                                        //skip file
                                    }else{
                                        var obj = new Object();
                                        obj.originalextension = asset.extensions[0];
                                        obj.title = asset.name;
                                        obj.url = asset.files.transformBaseUrl.url;
                                        obj.type = asset.type;
                                        obj.extensions = asset.extension;
                                        obj.databaseId = asset.databaseId;
                                        obj.description = asset.description;
                                        obj.volumehandle = volumehandle;
                                        obj.folder = folder;
                                        objarray.push(obj);
                                    }
                                }
                                fetch('/actions/users/session-info', {
                                    headers: {
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(session => {
                                    var jsonString = JSON.stringify(objarray);

                                    $.ajax({
                                        type: 'POST',
                                        url: '/actions/craft-bynder-assets/bynder-asset/save-bynder-asset/',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-Token': session.csrfTokenValue
                                        },
                                        data: {
                                            'data': jsonString
                                        },
                                        success: function(response) {
                                            console.log('Value saved successfully!');
                                            location.reload();
                                        },
                                        error: function(response) {
                                            console.log('An error occurred while saving the value');
                                        }
                                    });
                                })
                                .catch(error => {
                                    console.error('Error fetching CSRF token:', error);
                                });
                                    
                            }
                        });
                    });
                }
            }
        });
     

})(jQuery);
