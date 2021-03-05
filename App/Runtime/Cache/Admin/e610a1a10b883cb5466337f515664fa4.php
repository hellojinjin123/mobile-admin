<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>系统首页</title>

    <link
      rel="stylesheet"
      type="text/css"
      href="__ADMIN__/Public/css/base.css"
    />
    <script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>
    <script src="__PUBLIC__/js/MSClass.js"></script>
    <style type="text/css">
      table {
        border-collapse: collapse;
        border-spacing: 0;
      }

      table.website-info tbody td {
        padding: 9px;
        padding-left: 30px;
      }
      .red {
        color: red;
        font-weight: bold;
        font-weight: bold;
      }
      .c_013A6F {
        color: #013a6f;
      }
      .c_545454 {
        color: #545454;
      }
      .renewals {
        color: #4e7c00;
        margin-left: 20px;
        text-decoration: underline;
      }
      .renewals:hover {
        text-decoration: underline;
      }
      .module-list {
        margin: 0;
        padding: 0;
        overflow: hidden;
      }
      .module-list li {
        margin: 0;
        padding: 0;
        float: left;
        width: 135px;
        text-align: center;
        height: 130px;
        line-height: 130px;
      }
      .module-list li img {
        vertical-align: middle;
      }

      ul.circle {
        list-style-type: circle;
      }
      ul.square {
        list-style-type: square;
      }
      ol.upper-roman {
        list-style-type: upper-roman;
      }
      ol.lower-alpha {
        list-style-type: lower-alpha;
      }

      #TextContent1 li {
        height: 18px;
        font-size: 12px;
      }
    </style>

    <script type="text/javascript">
      function formatFloat(src, pos) {
        return Math.round(src * Math.pow(10, pos)) / Math.pow(10, pos);
      }
      $(function () {
        new Marquee(
          ["TextDiv1", "TextContent1"],
          0,
          1,
          "85%",
          20,
          20,
          4000,
          2000,
          18
        );

        $.get("__APP__/Admin/System/getSpaceSize", {}, function (size) {
          var space_mb = "<?php echo $custom['space_mb']; ?>";
          $("#use_size").text(size);
          $("#surplus_size").text(
            formatFloat(space_mb - parseFloat(size), 2) + " MB"
          );});
      });
    </script>
  </head>
  <body>
    <table style="margin: 20px">
      <tbody>
        <td valign="top">
          <div style="border: 1px #d5d5d5 solid; width: 550px; padding: 20px">
            <ul class="module-list">
              <?php if(is_array($moduleList)): $i = 0; $__LIST__ = $moduleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><?php if($_SESSION[C('USER_AUTH_KEY')]['superadmin']==true ||
                  in_array($vo['id'],$_SESSION['access'][$vo['modelaction']])){ ?>
                <li>
                  <a
                    href="#"
                    onclick="parent.goToModule('#<?php echo ($vo["modelaction"]); ?>','<?php echo ($vo["modelaction"]); ?>/index/mid/<?php echo ($vo["id"]); ?>','Index/sidemenu/mid/<?php echo ($vo["id"]); ?>')"
                    ><img src="__ADMIN__/Public/imgs/<?php echo ($vo["modelaction"]); ?>.jpg"
                  /></a>
                </li>
                <?php } ?><?php endforeach; endif; else: echo "" ;endif; ?>

              <li>
                <a href="__APP__/<?php echo ($default_group); ?>" target="_blank"
                  ><img src="__ADMIN__/Public/imgs/Home.jpg"
                /></a>
              </li>
            </ul>
          </div>
        </td>
        <td valign="top">
          <div style="border: 1px #d5d5d5 solid; margin-left: 20px">
            <table class="website-info">
              <thead>
                <tr>
                  <td
                    style="
                      background: url('__ADMIN__/Public/imgs/webinfo_bg.jpg');
                    "
                  >
                    <img src="__ADMIN__/Public/imgs/webinfo.jpg" />
                  </td>
                </tr>
                <tr>
                  <td valign="top">
                    <div
                      style="
                        background-color: #cdcdcd;
                        line-height: 20px;
                        padding: 10px 0 10px 30px;
                      "
                    >
                      尊敬的客户
                      <strong class="c_013A6F"><?php echo $_SESSION["admin"]["username"];?></strong>
                      您好！您的网站现在状态如下：<br />
                      <span class="c_545454">开通正式空间时间：</span
                      ><span class="red"
                        ><?php echo date('Y年m月d日',$custom['begin_time']);?></span
                      >
                      <span class="c_545454">空间到期时间：</span
                      ><span class="red"
                        ><?php echo date('Y年m月d日',$custom['end_time']);?></span
                      >
                      <span class="c_545454">空间剩余时间：</span
                      ><strong class="red"
                        ><?php echo round(($custom['end_time']-time())/3600/24); ?></strong
                      >
                      天
                      <a href="mailto:wb@huyi.cn" class="renewals"
                        >我要延期续费</a
                      ><br />
                      <span class="c_545454">空间容量：</span
                      ><?php echo $space_mb = $custom['space_mb']; ?>MB，<span
                        class="c_545454"
                        >现使用容量：</span
                      ><span id="use_size">...</span>，<span class="c_545454"
                        >剩余：</span
                      ><span id="surplus_size">...</span>
                      <a href="mailto:wb@huyi.cn" class="renewals"
                        >我要增加容量</a
                      >
                    </div>
                  </td>
                </tr>
              </thead>
              <tbody>
                <?php if(is_array($moduleList)): $i = 0; $__LIST__ = $moduleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><?php switch($vo["modelaction"]): ?><?php case "News":  ?><tr>
                        <td style="background-color: #eaeaea">
                          已发布的新闻信息
                          <a href="#" class="red"><?php echo ($newsCount); ?></a> 条
                        </td>
                      </tr><?php break;?>
                    <?php case "Goods":  ?><tr>
                        <td>
                          已发布的产品信息
                          <a href="#" class="red"><?php echo ($goodsCount); ?></a> 条
                        </td>
                      </tr><?php break;?>
                    <?php case "Guestbook":  ?><tr>
                        <td style="background-color: #eaeaea">
                          收到留言
                          <a href="#" class="red"><?php echo ($guestbookCount); ?></a>
                          条，未读留言
                          <a href="#" class="red"><?php echo ($guestbookCountRead0); ?></a> 条
                        </td>
                      </tr><?php break;?>
                    <?php case "Advert":  ?><tr>
                        <td>
                          已发布的广告图片
                          <a href="#" class="red"><?php echo ($advertCount); ?></a> 张
                        </td>
                      </tr><?php break;?>
                    <?php case "Link":  ?><tr>
                        <td style="background-color: #eaeaea">
                          已发布友情链接
                          <a href="#" class="red"><?php echo ($linkCount); ?></a> 个
                        </td>
                      </tr><?php break;?>
                    <?php case "Download":  ?><tr>
                        <td>
                          已发布的下载文件
                          <a href="#" class="red"><?php echo ($downloadCount); ?></a> 个
                        </td>
                      </tr><?php break;?>
                    <?php case "Job":  ?><tr>
                        <td style="background-color: #eaeaea">
                          已发布的招聘职位
                          <a href="#" class="red"><?php echo ($jobCount); ?></a>
                          个，收到的应聘简历
                          <a
                            href="#"
                            onclick="parent.goToModule('#Job','Job/index','Index/sidemenu/pid/27')"
                            class="red"
                            ><?php echo ($jobrCount); ?></a
                          >
                          个
                        </td>
                      </tr><?php break;?>
                    <?php case "Member":  ?><tr>
                        <td>
                          已注册的会员
                          <a href="#" class="red"><?php echo ($memberCount); ?></a>
                          人，今天注册的会员
                          <a href="#" class="red"><?php echo ($todayMemberCount); ?></a> 人
                        </td>
                      </tr><?php break;?><?php endswitch;?><?php endforeach; endif; else: echo "" ;endif; ?>

                <tr>
                  <td style="background-color: #f2f2f2">
                    <div
                      style="
                        color: red;
                        float: left;
                        height: 20px;
                        line-height: 18px;
                      "
                    >
                      温馨提示：
                    </div>
                    <div
                      id="TextDiv1"
                      style="
                        line-height: 18px;
                        border-left: none;
                        text-align: left;
                        width: 85%;
                        min-width: 400px;
                        height: 20px;
                        overflow: hidden;
                      "
                    >
                      <ul id="TextContent1">
                        <li>
                          离上次登录后台时间已有100天，为了有效提升网站排名，请及时更新网站内容。
                        </li>
                        <li>
                          定期更新网站内容提升搜索引擎的关注度，增加搜索引擎收录数。
                        </li>
                        <li>定期转载同行业最新资讯，增加搜索引擎收录数。</li>
                        <li>
                          网站title尽量围绕关键词来写，在Title中可加上官方网站，增加信任度。
                        </li>
                        <li>网页标题（title）建议长度小于等于80个字符。</li>
                        <li>
                          网页关键词（keywords）建议长度小于等于100个字符（50个汉字），
                        </li>
                        <li>关键词之间以英文字符逗号隔开。</li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </td>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2">
            <div class="bottom-copyright" style="margin: 20px 0">
              版权所有.jmh. 技术支持.jmh-技术部&nbsp;&nbsp;&nbsp;
            </div>
          </td>
        </tr>
      </tfoot>
    </table>
  </body>
</html>