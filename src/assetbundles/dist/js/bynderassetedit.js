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
                if($("#fields-datLocation").length){
                var pathparts =  window.location.pathname.split("/");
                $("#sidebar li a").each(function(){
                  if($(this).hasClass("sel")){
                    folder = $(this).data("folder-id");
                  }
                });
                var altvalue = $("#fields-datLocation").val();
                if(altvalue != "")
                {
                    var datLocation = $.get(altvalue);
                    var thumb = altvalue+"?io=transform:fit,width:350,height:190";
                    var thumb2x = altvalue+"?io=transform:fit,width:700,height:380";
                    $(".preview-thumb img").attr("srcset",thumb+" 350w,"+thumb2x+" 700w").attr("sizes","350px");
                    
                }
                var mediavalue = $("#fields-mediaId").val();
                if(mediavalue != ""){
                    var editUrl = "https://"+options.portalurl+"/media/?mediaId="+mediavalue;
                    $("#edit-btn").after('<a href="'+editUrl+'" target="_blank" id="edit-asset" class="btn edit-asset" aria-label="Edit asset" tabindex="0">Edit asset</button>');
                    $("#edit-btn").remove();
                    
                }

                $('#main-form').append('<input type="hidden" value="'+altvalue+'" id="oldalt" name="old-alt">')
                if(pathparts[2] == "assets" && pathparts[3] == "edit"){
                    $("#action-buttons .btngroup").first().append('<button title="Replace asset with a Bynder asset" type="button" class="btn bynder hairline-dark btngroup-btn-last"><img height="20" width="20" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iMzAiIHZpZXdCb3g9IjAgMCA0MCAzMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzI5MDdfMzQ1OCkiPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTIzLjMgMy4yMzQwMkwxMC41MTcgMTUuOTQyTDYuODYzIDEyLjMwNUM2LjIzMDg1IDExLjYwMzYgNS44ODUzNSAxMC42OTAyIDUuODk1IDkuNzQ2MDJDNS44OTUgNy42MTkwMiA3LjYxNCA1LjkyMjAyIDkuNzY2IDUuOTIyMDJDMTAuNzM0IDUuOTIyMDIgMTEuNTg2IDYuMjUzMDIgMTIuMzA5IDYuODcyMDJDMTIuNTM5IDcuMDcyMDIgMTMuMTg5IDcuNzM0MDIgMTMuMTg5IDcuNzM0MDJMMTcuMjM1IDMuNzA5MDJMMTYuMDY1IDIuNTQ0MDJDMTQuMzc0IDAuOTUwMDE5IDEyLjA2MiAxLjkxOTQ3ZS0wNSA5LjUzNCAxLjkxOTQ3ZS0wNUM0LjI3NiAxLjkxOTQ3ZS0wNSAwIDQuMjQwMDIgMCA5LjQ3MzAyQzAgMTEuODczIDAuOTEgMTQuMTAyIDIuMzQgMTUuNzRMMTAuNTQ1IDIzLjkzNEwyNy42OTIgNi44NzAwMkMyOC4zOTM4IDYuMjQwNDEgMjkuMzA2MiA1Ljg5NjggMzAuMjQ5IDUuOTA3MDJDMzAuNzU0NiA1LjkwNjM2IDMxLjI1NTQgNi4wMDU2MSAzMS43MjI1IDYuMTk5MDZDMzIuMTg5NyA2LjM5MjUyIDMyLjYxNCA2LjY3NjM3IDMyLjk3MTEgNy4wMzQzMkMzMy4zMjgyIDcuMzkyMjYgMzMuNjExIDcuODE3MjMgMzMuODAzNCA4LjI4NDgyQzMzLjk5NTggOC43NTI0MiAzNC4wOTM4IDkuMjUzNDEgMzQuMDkyIDkuNzU5MDJDMzQuMDkyIDEwLjcyMyAzMy43NTkgMTEuNTg1IDMzLjEyNCAxMi4yODlMMjEuNzI2IDIzLjYzMkMyMS4yOTMgMjQuMDkyIDIwLjY3MiAyNC4zMzYgMTkuOTkzIDI0LjM1MUMxOS42NzIzIDI0LjM1MjQgMTkuMzU0OSAyNC4yODY2IDE5LjA2MTIgMjQuMTU3OEMxOC43Njc1IDI0LjAyODkgMTguNTA0MSAyMy44NCAxOC4yODggMjMuNjAzTDE3LjQzNiAyMi43NTVMMTMuNDA2IDI2Ljc2NUwxNC4yMjkgMjcuNTcxQzE0Ljk4NTYgMjguMzM5NCAxNS44ODczIDI4Ljk0OTkgMTYuODgxOCAyOS4zNjY4QzE3Ljg3NjIgMjkuNzgzOCAxOC45NDM2IDI5Ljk5OSAyMC4wMjIgMzBDMjIuMjc1IDMwIDI0LjI5OCAyOS4wOCAyNS43NzEgMjcuNTg1TDM3LjY0NSAxNS43NEMzOS4xNjI4IDE0LjAwNSAzOS45OTk2IDExLjc3ODIgNDAgOS40NzMwMkM0MCA0LjI0MDAyIDM1LjcyNCAxLjkxOTQ3ZS0wNSAzMC40NjYgMS45MTk0N2UtMDVDMjkuMTEwMSAtMC4wMDI3MDQzNSAyNy43NjkyIDAuMjg0NDM2IDI2LjUzMzMgMC44NDIxOTVDMjUuMjk3NCAxLjM5OTk1IDI0LjE5NSAyLjIxNTQ1IDIzLjMgMy4yMzQwMloiIGZpbGw9IiMxMjZERkUiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF8yOTA3XzM0NTgiPgo8cmVjdCB3aWR0aD0iNDAiIGhlaWdodD0iMzAiIGZpbGw9IndoaXRlIi8+CjwvY2xpcFBhdGg+CjwvZGVmcz4KPC9zdmc+Cg==" alt="Bynder logo"/>&nbsp;Replace file</button>');
                    var trigger = $(".bynder");
                    $("#sidebar li a").on('click',function(){
                        folder = $(this).data("folder-id");
                        volumehandle = $(this).data("volume-handle");
                    })
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
                           onSuccess: function(assets, additionalInfo) {
                            for (let i = 0; i < assets.length; i++) {
                             var asset = assets[i];
                             var obj = new Object();
                             
                             obj.originalextension = asset.extensions[0];
                             obj.title = asset.name;
                             if(asset.files.transformBaseUrl === undefined)
                             {
                              alert("No transformbaseurl present");
                             }else{
                              obj.url = asset.files.transformBaseUrl.url;
                              obj.type = asset.type;
                              obj.databaseId = asset.databaseId;
                              obj.description = asset.description;
                              cleantitle = asset.name.replace(/[-_]/g, " ").replace(/[^\w\s]/gi, '');
                              cleantitle = cleantitle.replace(/\b[a-z]/g, function(letter) {
                                  return letter.toUpperCase();
                              });
                              var newDatLocation = obj.url.toLowerCase()+"."+obj.originalextension;
                              if($("#fields-datLocation").length){
                              $("#fields-datLocation").val(newDatLocation);
                                var thumb = newDatLocation+"?io=transform:fit,width:350,height:190";
                                var thumb2x = newDatLocation+"?io=transform:fit,width:700,height:380";
                                $(".preview-thumb img").attr("srcset",thumb+" 350w,"+thumb2x+" 700w").attr("sizes","350px");
                              }
                              $("#title").val(cleantitle);
                              if($("#fields-mediaId").length){
                                $("#fields-mediaId").val(asset.databaseId);
                              }
                              }
                            }
                           }
                        });
                     });
                }
                }
            }
        });
      
})(jQuery);
