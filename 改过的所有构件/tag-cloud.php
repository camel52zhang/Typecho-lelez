<?php
/**
 * 标签云页面模板
 * 
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="col-mb-12 col-8" id="main" role="main">
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="post-content" itemprop="articleBody" style="margin-top: 20px;">
            <?php
            // 获取标签数据用于统计
            $tags = Typecho_Widget::widget('Widget_Metas_Tag_Cloud');
            $tagData = array();
            $totalTags = 0;
            
            if ($tags->have()) {
                while ($tags->next()) {
                    $tagData[] = array(
                        'name' => $tags->name,
                        'count' => $tags->count,
                        'permalink' => $tags->permalink
                    );
                    $totalTags++;
                }
            }
            ?>
            
            <!-- 添加图标和详细描述 -->
            <p style="text-align: center; color: #666; margin-bottom: 30px; font-size: 16px;">
                🏷️ 本站共有 <strong><?php echo $totalTags; ?></strong> 个标签，点击标签可以查看相关文章。
            </p>
            
            <div style="text-align: center; padding: 20px 0;">
                <?php
                if ($totalTags > 0) {
                    // 计算标签大小
                    $maxCount = 0;
                    $minCount = PHP_INT_MAX;
                    
                    foreach ($tagData as $tag) {
                        $maxCount = max($maxCount, $tag['count']);
                        $minCount = min($minCount, $tag['count']);
                    }
                    
                    $sizeRange = $maxCount - $minCount;
                    if ($sizeRange == 0) $sizeRange = 1;
                    
                    echo '<div style="line-height: 2.5;">';
                    foreach ($tagData as $tag) {
                        $sizeLevel = ceil(($tag['count'] - $minCount) / $sizeRange * 4) + 1;
                        $fontSize = 12 + ($sizeLevel * 2); // 12px, 14px, 16px, 18px, 20px
                        $padding = 6 + ($sizeLevel * 2);
                        
                        echo '<a href="' . $tag['permalink'] . '" style="display: inline-block; margin: 5px 8px; padding: ' . $padding . 'px ' . ($padding + 6) . 'px; background: #e3f2fd; border-radius: 20px; text-decoration: none; color: #1565c0; border: 1px solid #bbdefb; font-size: ' . $fontSize . 'px; transition: all 0.3s;" title="' . $tag['count'] . '篇文章">';
                        echo $tag['name'];
                        echo ' <span style="font-size: ' . ($fontSize - 4) . 'px; color: #64b5f6;">(' . $tag['count'] . ')</span>';
                        echo '</a> ';
                    }
                    echo '</div>';
                } else {
                    echo '<p style="text-align: center; color: #999;">暂无标签</p>';
                }
                ?>
            </div>
            
            <!-- 添加返回首页链接 -->
            <div style="text-align: center; margin-top: 50px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
                <a href="<?php $this->options->siteUrl(); ?>" style="display: inline-block; padding: 10px 20px; background: #f8f9fa; border-radius: 5px; text-decoration: none; color: #495057; border: 1px solid #dee2e6; transition: all 0.3s;">
                    ← 返回首页
                </a>
            </div>
        </div>
    </article>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>