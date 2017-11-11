<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            {{--@can('system')--}}
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-bank"></i> <span>系统管理</span>
                    <span class="pull-right-container"></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/permissions"><i class="fa fa-circle-o"></i> 权限管理</a></li>
                    <li><a href="/admin/users"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                    <li><a href="/admin/roles"><i class="fa fa-circle-o"></i> 角色管理</a></li>
                </ul>
            </li>

            {{--<li class="treeview active">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>学校专业管理</span>--}}
                    {{--<span class="pull-right-container"></span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="/admin/schools"><i class="fa fa-circle-o"></i> 学校管理</a></li>--}}
                    {{--<li><a href="/admin/majors"><i class="fa fa-circle-o"></i> 专业管理</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--@endcan--}}
            {{--            @can('post')--}}
            {{--<li class="active treeview">--}}
                {{--<a href="/admin/posts">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>文章管理</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endcan--}}
            {{--            @can('topic')--}}
            {{--<li class="active treeview">--}}
                {{--<a href="/admin/majorcourses">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>专业课管理</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="active treeview">--}}
                {{--<a href="/admin/topics">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>专题管理</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="active treeview">--}}
                {{--<a href="/admin/scorelines">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>分数线管理</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="active treeview">--}}
                {{--<a href="/admin/lectures">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>讲座管理</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endcan--}}
            {{--            @can('notice')--}}
            <li class="active treeview">
                <a href="/admin/forums">
                    <i class="fa fa-dashboard"></i> <span>论坛管理</span>
                </a>
            </li>
            <li class="active treeview">
                <a href="/admin/shuoshuos">
                    <i class="fa fa-dashboard"></i> <span>说说管理</span>
                </a>
            </li>
            <li class="active treeview">
                <a href="/admin/posts">
                    <i class="fa fa-dashboard"></i> <span>经验贴管理</span>
                </a>
            </li>
            <li class="active treeview">
                <a href="/admin/questions">
                    <i class="fa fa-dashboard"></i> <span>问答管理</span>
                </a>
            </li>
            <li class="active treeview">
                <a href="/admin/files">
                    <i class="fa fa-dashboard"></i> <span>文件管理</span>
                </a>
            </li>
            {{--<li class="active treeview">--}}
                {{--<a href="/admin/notices">--}}
                    {{--<i class="fa fa-dashboard"></i> <span>通知管理</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endcan--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
