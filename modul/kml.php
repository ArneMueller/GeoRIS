<?
/*
 * Export der GEO Daten im KML format
 * 
 * (A) Mario XEdP3X
 * (c) GPL
 */


KML_GET();


if (!$kml){
	header("HTTP/1.0 500 No Data");
	die('No Data Selected');
}

header('Content-type: application/vnd.google-earth.kml+xml');

echo'<?xml version="1.0" encoding="UTF-8"?>'."\r\n"; ?>
<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
<Document>
	<name>KmlFile</name>
	<open>1</open>
	
	<StyleMap id="msn_ylw-pushpin">
		<Pair>
			<key>normal</key>
			<styleUrl>#sn_ylw-pushpin</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#sh_ylw-pushpin</styleUrl>
		</Pair>
	</StyleMap>
	<StyleMap id="msn_ylw-pushpin0">
		<Pair>
			<key>normal</key>
			<styleUrl>#sn_ylw-pushpin0</styleUrl>
		</Pair>
		<Pair>
			<key>highlight</key>
			<styleUrl>#sh_ylw-pushpin0</styleUrl>
		</Pair>
	</StyleMap>
	
	
	<StyleMap id="punkt">
		<Pair>
			<key>normal</key>
			<styleUrl>#sn_punkt</styleUrl>
		</Pair>
	</StyleMap>
	<Style id="sn_punkt">
		<LineStyle>
			<color>ff0088ff</color>
			<width>7</width>
		</LineStyle>
	</Style>
	
	
	
	<Style id="sn_ylw-pushpin">
		<LineStyle>
			<color>ff0088ff</color>
			<width>3</width>
		</LineStyle>
	</Style>
	
	<Style id="sn_ylw-pushpin0">
		<LineStyle>
			<color>Ff0088ff</color>
			<width>1</width>
		</LineStyle>
		<PolyStyle>
			<color>500088ff</color>
		</PolyStyle>
	</Style>
	
	
	<Folder>
		<name>GeoRIS</name>
		<open>0</open>
		<description>GeoRIS export <?=date("d m y")?> (c) CC-BY-SA</description>
		
		
		<?php while( list ( $key, $val ) = each ( $kml["way"] ) ){?>
		<Placemark>
			<name><?=$val["titel"]?><?=$val["name"]?" (".$val["name"].")":""?></name>
			<description><![CDATA[
				<!-- <a href="<?=$val["url"]?>" style="text-decoration:none; position: absolute; color: #003a6b; top: 0px; right: 10px; z-index: 1;">Mehr</a> -->
				<div style="max-width: 600px;">
					<?=str_replace("\n","<br />",$val["text"])?>
					<h2></h2>
					<?php if ($val["url"]){?><a href="<?=$val["url"]?>" target="_blank" style="text-decoration:none; color: #003a6b;">Weiter lesen...</a><?php }?>
					<?php if ($val["pad"]){?><a href="<?=$val["pad"]?>" target="_blank" style="text-decoration:none; color: #003a6b;">Pad</a><?php }?>
					<?php if ($val["wiki"]){?><a href="<?=$val["wiki"]?>" target="_blank" style="text-decoration:none; color: #003a6b;">Wiki</a><?php }?>
					<?php if ($val["forum"]){?><a href="<?=$val["forum"]?>" target="_blank" style="text-decoration:none; color: #003a6b;">Forum</a><?php }?>
				</div>]]></description>
			<?php if (Count($val["data"])>1){?>
			<styleUrl>#msn_ylw-pushpin</styleUrl>
			<LineString>
					<LinearRing>
						<coordinates>
							<?
							while( list ( $key2, $val2 ) = each ( $val["data"] ) ){
								echo $val2["lon"].",".$val2["lat"]." ";
							}?>
						</coordinates>
					</LinearRing>
			</LineString>
			<?php }else{?>
			<styleUrl>#punkt</styleUrl>
			<LineString>
					<LinearRing>
						<coordinates> <?=$val["data"][0]["lon"].",".$val["data"][0]["lat"]?> <?=($val["data"][0]["lon"]+0.00001).",".($val["data"][0]["lat"]+0.00001)?>
						</coordinates>
					</LinearRing>
			</LineString>
			
			<?php }?>
		</Placemark>
		<?php } // kml["way"]
		

	$set = $kml["outer"];
	while( list ( $key, $val ) = each ( $set  ) ){
		$set2[$val["ant"]]["outer"][] = $val;
	}
	
	$set = $kml["inner"];
	while( list ( $key, $val ) = each ( $set  ) ){
		$set2[$val["ant"]]["inner"][] = $val;
	}
	
	while( list ( $key, $kml ) = each ( $set2  ) ){
	 if ($kml["outer"]){?>

		<Placemark>
			<name><?=$kml["outer"][0]["titel"]?><?=$kml["outer"][0]["name"]?" (".$kml["outer"][0]["name"].")":""?></name>
			<?php $val = $kml["outer"][0];?>
			<description><![CDATA[
				<!-- <a href="<?=$val["url"]?>" style="text-decoration:none; position: absolute; color: #003a6b; top: 0px; right: 10px; z-index: 1;">Mehr</a> -->
				<div style="max-width: 600px;">
					<?=str_replace("\n","<br />",$val["text"])?>
					<h2></h2>
					<?php if ($val["url"]){?><a href="<?=$val["url"]?>" target="_blank" style="text-decoration:none; color: #003a6b;">Weiter lesen...</a><?php }?>
					<?php if ($val["pad"]){?><a href="<?=$val["pad"]?>" target="_blank" style="text-decoration:none; color: #003a6b;">Pad</a><?php }?>
					<?php if ($val["wiki"]){?><a href="<?=$val["wiki"]?>" target="_blank" style="text-decoration:none; color: #003a6b;">Wiki</a><?php }?>
					<?php if ($val["forum"]){?><a href="<?=$val["forum"]?>" target="_blank" style="text-decoration:none; color: #003a6b;">Forum</a><?php }?>
				</div>]]></description>
			<styleUrl>#msn_ylw-pushpin0</styleUrl>
			<Polygon>
				<innerBoundaryIs>
					<?php while( list ( $key, $val ) = each ( $kml["outer"] ) ){?>
					<LinearRing>
						<coordinates>
							<?
							while( list ( $key2, $val2 ) = each ( $val["data"] ) ){
								echo $val2["lon"].",".$val2["lat"]." ";
							}?>
						</coordinates>
					</LinearRing>
					<?php }?>
				</innerBoundaryIs>
				
				<?php if ($kml["inner"]){?>
				<outerBoundaryIs>
					<?php while( list ( $key, $val ) = each ( $kml["inner"] ) ){?>
					<LinearRing>
						<coordinates>
							<?
							while( list ( $key2, $val2 ) = each ( $val["data"] ) ){
								echo $val2["lon"].",".$val2["lat"]." ";
							}?>
						</coordinates>
					</LinearRing>
					<?php }?>
				</outerBoundaryIs>
				<?php }?>
			</Polygon>
		</Placemark>
		
		<?php }
		
		} // Gebiete?>
		
		
	</Folder>
</Document>
</kml>
