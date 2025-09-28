<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="col-mb-12 col-8" id="main" role="main">
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <h1 class="post-title" itemprop="name headline">
            <a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
        </h1>
        <ul class="post-meta">
            <li itemprop="author" itemscope itemtype="http://schema.org/Person">
                <?php _e('作者: '); ?>
                <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a>
            </li>
            <li><?php _e('时间: '); ?>
                <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
            </li>
            <li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
        </ul>

        <!-- ========== 开始：PHP 生成目录并存入全局变量 ========== -->
        <?php
        $content = $this->content;
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // 防止 HTML 不规范报错
        $dom->loadHTML('<?xml encoding="utf-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $headings = $dom->getElementsByTagName('h2');
        $h3s = $dom->getElementsByTagName('h3');
        $directory = '';
        $index = 0;

        if ($headings->length > 0 || $h3s->length > 0) {
            $directory = '<div class="toc-container"><ul class="toc-list">';
            
            foreach ([$headings, $h3s] as $tag => $list) {
                $tagName = $tag == 0 ? 'h2' : 'h3';
                foreach ($list as $heading) {
                    $text = $heading->textContent;
                    $id = 'toc-' . $index;
                    $heading->setAttribute('id', $id);
                    $directory .= sprintf(
                        '<li class="toc-item toc-%s"><a href="#%s">%s</a></li>',
                        $tagName, $id, htmlspecialchars($text)
                    );
                    $index++;
                }
            }
            
            $directory .= '</ul></div>';
        } else {
            $directory = '<p>（本文暂无目录）</p>';
        }

        // 存入全局变量，供 sidebar.php 使用
        $GLOBALS['post']['directory'] = $directory;
        $this->content = $dom->saveHTML();
        ?>
        <!-- ========== 结束：PHP 生成目录 ========== -->

        <div class="post-content" itemprop="articleBody">
            <?php echo $this->content; ?>
        </div>

        <p itemprop="keywords" class="tags"><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></p>

        <!-- 你的“上一篇/下一篇”导航和返回按钮等保持不变 -->
        <ul class="post-near">
            <li><span>上一篇</span><?php $this->thePrev('%s', '没有了'); ?></li>
            <li><span>下一篇</span><?php $this->theNext('%s', '没有了'); ?></li>
        </ul>

        <p class="back-link" style="text-align: right;">
            <a href="javascript:history.back()">&laquo; 返回上页</a>
        </p>

    </article>

    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>

<!-- ================== 代码块复制功能 开始 ================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 获取所有代码块
    const codeBlocks = document.querySelectorAll('pre code');

    codeBlocks.forEach(function (block) {
        // 创建复制按钮
        const button = document.createElement('button');
        button.className = 'copy-code-btn';
        button.type = 'button';
        button.innerText = '⧉';

        // 将按钮插入到 pre 容器中（不是 code 内部）
        const pre = block.parentElement;
        pre.style.position = 'relative'; // 确保定位正常
        button.style.cssText = `
            position: absolute;
            top: 8px;
            right: 8px;
            z-index: 99;
            padding: 4px 8px;
            font-size: 12px;
            color: #fff;
            background: #007acc;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s, background 0.3s;
        `;
        pre.appendChild(button);

        // 鼠标悬停效果
        button.addEventListener('mouseenter', () => button.style.opacity = '1');
        button.addEventListener('mouseleave', () => button.style.opacity = '0.7');

        // 点击复制
        button.addEventListener('click', async () => {
            const code = block.textContent;
            try {
                // 使用现代的 Clipboard API 复制文本
                await navigator.clipboard.writeText(code);
                button.innerText = '✅ 已复制';
                button.style.background = '#2ecc71';
            } catch (err) {
                // 如果 Clipboard API 失败，使用回退方案
                const textarea = document.createElement('textarea');
                textarea.value = code;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    button.innerText = '✅ 已复制';
                    button.style.background = '#2ecc71';
                } catch (e) {
                    button.innerText = '❌ 复制失败';
                    button.style.background = '#e74c3c';
                }
                document.body.removeChild(textarea);
            } finally {
                // 无论成功或失败，都在 2 秒后恢复按钮状态
                setTimeout(() => {
                    button.innerText = '⧉';
                    button.style.background = '#007acc';
                }, 2000);
            }
        });
    });
});
</script>

