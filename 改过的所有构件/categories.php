<?php
/**
 * 分类页面模板
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
            // 获取分类数据用于统计
            $categories = Typecho_Widget::widget('Widget_Metas_Category_List');
            $catData = array();
            $totalCategories = 0;
            $totalArticles = 0;
            
            if ($categories->have()) {
                while ($categories->next()) {
                    $catData[] = array(
                        'name' => $categories->name,
                        'count' => $categories->count,
                        'permalink' => $categories->permalink
                    );
                    $totalCategories++;
                    $totalArticles += $categories->count;
                }
            }
            ?>
            
            <!-- 添加图标和详细描述 -->
            <p style="text-align: center; color: #666; margin-bottom: 30px; font-size: 16px;">
                📁 本站共有 <strong><?php echo $totalCategories; ?></strong> 个分类，包含 <strong><?php echo $totalArticles; ?></strong> 篇文章，点击分类可以查看相关文章。
            </p>
            
            <div style="text-align: center; padding: 20px 0;">
                <?php
                if ($totalCategories > 0) {
                    // 计算分类大小
                    $maxCount = 0;
                    $minCount = PHP_INT_MAX;
                    
                    foreach ($catData as $category) {
                        $maxCount = max($maxCount, $category['count']);
                        $minCount = min($minCount, $category['count']);
                    }
                    
                    $sizeRange = $maxCount - $minCount;
                    if ($sizeRange == 0) $sizeRange = 1;
                    
                    echo '<div style="line-height: 2.5;">';
                    foreach ($catData as $category) {
                        $sizeLevel = ceil(($category['count'] - $minCount) / $sizeRange * 4) + 1;
                        $fontSize = 14 + ($sizeLevel * 2);
                        $padding = 8 + ($sizeLevel * 2);
                        
                        echo '<a href="' . $category['permalink'] . '" style="display: inline-block; margin: 6px 10px; padding: ' . $padding . 'px ' . ($padding + 8) . 'px; background: #e8f5e8; border-radius: 25px; text-decoration: none; color: #2e7d32; border: 1px solid #c8e6c9; font-size: ' . $fontSize . 'px; transition: all 0.3s;" title="' . $category['count'] . '篇文章">';
                        echo $category['name'];
                        echo ' <span style="font-size: ' . ($fontSize - 4) . 'px; color: #66bb6a;">(' . $category['count'] . ')</span>';
                        echo '</a> ';
                    }
                    echo '</div>';
                } else {
                    echo '<p style="text-align: center; color: #999;">暂无分类</p>';
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