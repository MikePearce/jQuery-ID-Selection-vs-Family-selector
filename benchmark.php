<?php
    /**
     * This document is a test to see whether using IDs to select javascript
     * is faster than using parent/child/sibling
     */

    // First, let's create some dummy data.
    $stuff = array();
    for($i = 0; $i < 100; $i++)
    {
        array_push(
                $stuff,
                array
                (
                    'id'    => mt_rand(0, 100),
                    'value' => 'badger'.$i
                )
        );
    }

?>
<!doctype html>
<html>
	<head>
		<title>ID vs Family Benchmark test</title>
		<meta charset="utf-8" />
                <link rel="stylesheet" media="screen" href="style.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
                <script language="javascript">
                $(document).ready(function(){

                    function microtime (get_as_float) {
                        // http://kevin.vanzonneveld.net
                        // +   original by: Paulo Freitas
                        // *     example 1: timeStamp = microtime(true);
                        // *     results 1: timeStamp > 1000000000 && timeStamp < 2000000000

                        var now = new Date().getTime() / 1000;
                        var s = parseInt(now, 10);

                        return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
                    }

                    // Listen for a click on teh badgers
                    $('.aDivByAnyOtherName').click(function() {

                        // Grab the text and id
                        text = $(this).text();
                        id = $(this).attr('id').split("_")[1];

                        // FIRST UP via ID
                        idStart = microtime(1);
                        $('#dataContainer_'+id).text('ninja '+id);
                        idEnd = microtime(1);

                        // Then via children
                        childrenStart = microtime(1);
                        $(this).children('div.dataContainer').text('ninja2 '+id);
                        childrenEnd = microtime(1);

                        // Then via parent/children
                        parentChildrenStart = microtime(1);
                        $(this).parent().children('div.dataContainer').text('ninja3 '+id);
                        parentChildrenEnd = microtime(1);

                        // Then update the times.
                        $('#idTime').val(idEnd - idStart);
                        $('#childrenTime').val(childrenEnd - childrenStart);
                        $('#parentTime').val(parentChildrenEnd - parentChildrenStart);
                    })

                })


                </script>

	</head>
	<body>
            <div id="displayLeft">
                <table>
                <? foreach($stuff AS $stuffDetail): ?>
                    <tr><td>
                    <div
                        id      = "anId_<?= $stuffDetail['id']; ?>"
                        class   = "aDivByAnyOtherName"
                    >
                        <?= $stuffDetail['value']; ?>
                        <div 
                            id      = "dataContainer_<?= $stuffDetail['id']; ?>"
                            class   = "dataContainer"
                        >

                        </div>

                    </div>
                            </td></tr>
                <? endforeach; ?>

                    </table>
            </div>

            <div id="displayRight">
                <h2>Moo</h2>
                ID: <input type="text" id="idTime" value="" /><br />
                Children: <input type="text" id="childrenTime" value="" /><br />
                Parent: <input type="text" id="parentTime" value="" />
            </div>


	</body>
</html>

