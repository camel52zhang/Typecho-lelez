<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="col-mb-12 col-offset-1 col-3 kit-hidden-tb" id="secondary" role="complementary">

<?php if ($this->is('post')): ?>
    <!-- 文章页：只显示目录 -->
    <?php if (isset($GLOBALS['post']['directory']) && !empty($GLOBALS['post']['directory'])): ?>
        <section class="widget toc-widget">
            <h3 class="widget-title">文章目录</h3>
            <?php echo $GLOBALS['post']['directory']; ?>
        </section>
    <?php endif; ?>

<?php elseif ($this->template == 'categories.php'): ?>
    <!-- 分类页：只显示最新文章 -->
    <section class="widget">
        <h3 class="widget-title"><?php _e('最新文章'); ?></h3>
        <ul class="widget-list">
            <?php \Widget\Contents\Post\Recent::alloc()
                ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
        </ul>
    </section>
	
<?php elseif ($this->template == 'tag-cloud.php'): ?>
    <!-- 标签页：只显示最新文章 -->
    <section class="widget">
        <h3 class="widget-title"><?php _e('最新文章'); ?></h3>
        <ul class="widget-list">
            <?php \Widget\Contents\Post\Recent::alloc()
                ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
        </ul>
    </section>
	
<?php elseif ($this->template == 'timeline.php'): ?>
    <!-- 时间线归档页：只显示最新文章 -->
    <section class="widget">
        <h3 class="widget-title"><?php _e('最新文章'); ?></h3>
        <ul class="widget-list">
            <?php \Widget\Contents\Post\Recent::alloc()
                ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
        </ul>
    </section>
	
 <?php elseif ($this->title == '关于' || $this->title == '👤关于'): ?>
    <!-- 关于页 -->
    <section class="widget">
        <h3 class="widget-title"><?php _e('最近回复'); ?></h3>
        <ul class="widget-list">
            <?php \Widget\Contents\Post\Recent::alloc()
			    ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
        </ul>
    </section>

<?php else: ?>
    <!-- 其他页面（首页、归档、标签页等）：显示完整侧边栏 -->
    <?php $this->need('sidebar-full.php'); ?>

<?php endif; ?>

</div>

