<?php
$page = new Page("Add Rushee");
$page->setForm("/rush/addnew",'POST',true);

ob_start();
?>
(function( $ ) {
$.widget( "ui.combobox", {
    _create: function() {
        var input,
            self = this,
            select = this.element.hide(),
            selected = select.children( ":selected" ),
            value = selected.val() ? selected.text() : "",
            wrapper = this.wrapper = $( "<span>" )
                .addClass( "ui-combobox" )
                .insertAfter( select );

        input = $( "<input>" )
            .appendTo( wrapper )
            .val( value )
            .addClass( "ui-state-default ui-combobox-input" )
            .autocomplete({
                delay: 0,
                minLength: 0,
                source: function( request, response ) {
                    var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                    response( select.children( "option" ).map(function() {
                        var text = $( this ).text();
                        if ( this.value && ( !request.term || matcher.test(text) ) )
                            return {
                                label: text.replace(
                                    new RegExp(
                                        "(?![^&;]+;)(?!<[^<>]*)(" +
                                        $.ui.autocomplete.escapeRegex(request.term) +
                                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                    ), "<strong>$1</strong>" ),
                                value: text,
                                option: this
                            };
                    }) );
                },
                select: function( event, ui ) {
                    ui.item.option.selected = true;
                    self._trigger( "selected", event, {
                        item: ui.item.option
                    });
                },
                change: function( event, ui ) {
                    if ( !ui.item ) {
                        var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
                            valid = false;
                        select.children( "option" ).each(function() {
                            if ( $( this ).text().match( matcher ) ) {
                                this.selected = valid = true;
                                return false;
                            }
                        });
                        if ( !valid ) {
                            // remove invalid value, as it didn't match anything
                            $( this ).val( "" );
                            select.val( "" );
                            input.data( "autocomplete" ).term = "";
                            return false;
                        }
                    }
                }
            })
            .addClass( "ui-widget ui-widget-content ui-corner-left" );

        input.data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + item.label + "</a>" )
                .appendTo( ul );
        };

        $( "<a>" )
                .attr( "tabIndex", -1 )
                .attr( "title", "Show All Items" )
                .appendTo( wrapper )
                .button({
                    icons: {
                        primary: "ui-icon-triangle-1-s"
                    },
                    text: false
                })
                .removeClass( "ui-corner-all" )
                .addClass( "ui-corner-right ui-combobox-toggle" )
                .click(function() {
                    // close if already visible
                    if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
                        input.autocomplete( "close" );
                        return;
                    }

                    // work around a bug (likely same cause as #5265)
                    $( this ).blur();

                    // pass empty string as value to search for, displaying all results
                    input.autocomplete( "search", "" );
                    input.focus();
                });
        },

        destroy: function() {
            this.wrapper.remove();
            this.element.show();
            $.Widget.prototype.destroy.call( this );
        }
    });
})( jQuery );

$(function() {
    $( "#location" ).combobox();
    $("#brother").tokenInput("/ajax/membertoken",{theme:'facebook',prepopulate:[{id:<?php echo getUser()->id ?>,name:"<?php echo getUser()->getName() ?>"}]});
});
<?php
$page->js = ob_get_clean();

$box = new Box('formbox','Add Rushee');
ob_start();
?>
<label>First Name:<input name='name_f' /></label><br />
<label>Last Name:<input name='name_l' /></label><br />
<br />
<label>Email: <input name="email" type="email" /></label><br />
<label>Phone: <input name="phone" type="tel" /></label><br />
<label>Facebook Username: <input name="fbid" id="fbid" onchange="document.getElementById('fbpic').style.background = 'url(http://graph.facebook.com/'+ this.value +'/picture)';" /></label>
<div id="fbpic" style="height: 50px;width: 50px;display:inline-block;vertical-align: bottom;background:gray;">&nbsp;</div><br />
<label>Twitter Name: @<input name="twitid" id="twitid" onchange="document.getElementById('twitpic').style.background = 'url(https://api.twitter.com/1/users/profile_image?screen_name='+ this.value +')';" /></label>
<div id="twitpic" style="height:48px;width:48px;display:inline-block;vertical-align: bottom;background:gray;">&nbsp;</div><br />
<br/>
<br />
<label>YOG: <input name="yog" type="number" min="<?php echo date('Y') ?>" max="<?php echo date('Y')+4 ?>" value="<?php echo date('Y')+3 ?>" /></label><br />
<label>Major: <input name="major" /></label><br />
<label>Location:
    <select name="location" id="location">
        <option></option>
        <option>Morgan Hall</option>
        <option>Daniels Hall</option>
        <option>Riley Hall</option>
        <option>Stoddard A</option>
        <option>Stoddard B</option>
        <option>Stoddard C</option>
        <option>Institute Hall</option>
        <option>Founders Hall</option>
    </select>    
</label><br />
<label>Room: <input name="room" /></label>
<br />
<label>Brother Assigned: <input name="brother" id="brother" /></label>
<br />
<br />
<label>Photo: <input name="photo" type="file" accept="image/jpeg" /></label><br />
<br />
<button type="submit">Add</button>
<?php
$box->setContent(new BCStatic(ob_get_clean()));
$page->addBox($box,'tripple');

return $page;
?>