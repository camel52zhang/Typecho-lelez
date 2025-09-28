<?php
/**
 * 时间线归档页面模板
 * 
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');

// 获取文章统计
$stat = Typecho_Widget::widget('Widget_Stat');
?>

<div class="col-mb-12 col-8" id="main" role="main">
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="post-content" itemprop="articleBody" style="margin-top: 20px;">
            <p style="text-align: center; color: #666; margin-bottom: 30px; font-size: 16px;">
                📅 文章归档 · 共 <strong style="color: #d35400;"><?php echo $stat->publishedPostsNum; ?></strong> 篇文章
            </p>
            
            <div style="max-width: 800px; margin: 0 auto;">
                <?php
                // 使用最兼容的方式获取文章
                $db = Typecho_Db::get();
                $select = $db->select()->from('table.contents')
                    ->where('type = ?', 'post')
                    ->where('status = ?', 'publish')
                    ->where('password IS NULL')
                    ->order('created', Typecho_Db::SORT_DESC);
                
                $posts = $db->fetchAll($select);
                
                if ($posts) {
                    $currentYear = '';
                    $currentMonth = '';
                    
                    foreach ($posts as $post) {
                        $year = date('Y', $post['created']);
                        $month = date('m', $post['created']);
                        $day = date('d', $post['created']);
                        $monthStr = $year . '年' . $month . '月';
                        
                        // 显示年份标题
                        if ($year != $currentYear) {
                            if ($currentYear != '') {
                                echo '</div></div>';
                            }
                            echo '<div class="year-section" style="margin-bottom: 30px;">';
                            echo '<h2 style="color: #d35400; border-left: 4px solid #d35400; padding-left: 15px; margin-bottom: 20px;">' . $year . '年</h2>';
                            $currentYear = $year;
                            $currentMonth = '';
                        }
                        
                        // 显示月份标题
                        if ($month != $currentMonth) {
                            if ($currentMonth != '') {
                                echo '</div>';
                            }
                            echo '<div class="month-section" style="margin-bottom: 15px; padding-left: 20px;">';
                            echo '<h3 style="color: #e67e22; margin-bottom: 10px;">' . $monthStr . '</h3>';
                            $currentMonth = $month;
                        }
                        
                        // 修复链接生成：使用正确的permalink方法
                        $permalink = Typecho_Common::url('archives/' . $post['cid'] . '/', $this->options->index);
                        ?>
                        <div style="margin: 5px 0; padding: 3px 0; border-bottom: 1px dashed #ecf0f1;">
                            <span style="color: #7f8c8d; margin-right: 10px;"><?php echo $day; ?>日</span>
                            <a href="<?php echo $permalink; ?>" 
                               style="color: #2c3e50; text-decoration: none;"
                               onmouseover="this.style.color='#e74c3c'" 
                               onmouseout="this.style.color='#2c3e50'">
                                ● <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </div>
                        <?php
                    }
                    
                    // 关闭最后的容器
                    if ($currentYear != '') {
                        echo '</div></div>';
                    }
                } else {
                    echo '<p style="text-align: center; color: #999; padding: 50px 0;">暂无文章</p>';
                }
                ?>
            </div>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="<?php $this->options->siteUrl(); ?>" style="color: #666; text-decoration: none;">
                    ← 返回首页
                </a>
            </div>
        </div>
    </article>
</div>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>