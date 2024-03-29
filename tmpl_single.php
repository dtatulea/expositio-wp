			<?php if ( have_posts() ) while ( have_posts() ) {
							the_post();
							global $post;
							$strGalleryClass	=	'';
							$strPostContent	=	'';
							if (trim($post->post_content))
							{
								$strGalleryClass	.=	' wpscls-with-content';
								$strPostContent	.=	'<h2 class="wpscls-field-title wpscls-'.$post->post_name.'">'. get_the_title() .'</h2>';
								$strPostContent	.=	'<div class="wpscls-field-content">';
								ob_start();
								the_content();
								$strPostContent	.= ob_get_contents();
								ob_end_clean();
								$strPostContent	.=	'</div>';
							}

							$arrArgs = array	(
													'posts_per_page' => 0,
													'post_parent'	=>	$post->ID,
													'post_status'	=>	'any',
													'orderby'  => 'menu_order',
													'order' => 'ASC',
													'post_type'	=>	array('attachment'),
												);

							$the_query = new WP_Query( $arrArgs );
							$rows_img	=	$the_query->posts;
							$numItemsPerRow	=	100;
							$strResultGallery	=	'';
							$strResultGallery	.= '<table class="cls-table-gallery'.$strGalleryClass.'">';
							$strResultGallery	.= '<tr>';
							$strResultGallery	.= $strPostContent ? '<td class="wpscls-post-content">'.$strPostContent.'</td>' : '';

							if (count($rows_img) > 0 && !is_page())
							{
								foreach ($rows_img as $numKey01 => $row_img)
								{
									$strFullImg	=	$row_img->guid;
									$numTmpPos	=	strpos($strFullImg, '.', strlen($strFullImg) - 5);
									$strExt	=	strtolower(substr($strFullImg, $numTmpPos));
									$strThumb	=	substr($strFullImg, 0, $numTmpPos).$strExt;
									if ($strExt == '.jpg' || $strExt == '.jpeg' || $strExt == '.gif' || $strExt == '.png')
									{
										$strResultGallery	.=	'<td>'.'<img alt="'.$row_img->post_title.'" src="'.$strThumb.'" />';
										$strResultGallery	.=	'<h5>'.$row_img->post_title.'</h5>';
										$strResultGallery	.=	'</td>';
									}
								}
							}
							$strResultGallery	.= '</tr>';
							$strResultGallery	.= '</table>';

							if (count($rows_img) > 0 || $strPostContent) echo $strResultGallery;
							break;
						}
			?>
