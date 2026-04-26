<?php
include('../confing/common.php');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系统公告</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.layui.com/layui/v2.8.11/css/layui.min.css">
    <style>
        .announcement-container {
            background: linear-gradient(135deg, #f8f9fc 0%, #f1f5f9 100%);
            padding: 1rem 0.5rem;
            width: 100%;
            margin: 0 auto;
        }

        .timeline-wrapper {
            position: relative;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .modern-timeline {
            list-style: none;
            padding: 0;
            position: relative;
        }

        .timeline-item {
            position: relative;
            padding: 1.2rem 0;
            display: flex;
            gap: 1rem;
        }

        .timeline-marker {
            position: relative;
            flex: 0 0 30px;
        }

        .timeline-dot {
            width: 14px;
            height: 14px;
            background: linear-gradient(135deg, #09acf4 0%, #7dd3fc 100%);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(56, 189, 248, 0.2);
            position: absolute;
            left: 1px;
            top: 3px;
            z-index: 2;
        }

        .timeline-line {
            position: absolute;
            left: 7px;
            top: 20px;
            bottom: -1.2rem;
            width: 2px;
            background: linear-gradient(to bottom, #e0f2fe 0%, #bae6fd 100%);
            z-index: 1;
        }

        .announcement-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            border-left: 3px solid #09acf4;
            margin-top: 0.5rem;
        }

        .time-text {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .announcement-title {
            font-size: 1.15rem;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .announcement-content {
            color: #475569;
            line-height: 1.5;
            font-size: 0.9rem;
        }

        /* 保持原有标签样式 */
        .tag {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 5px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.8rem;
        }
        .zhiding-tag {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .admin-tag {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .load-more-btn {
            background: linear-gradient(135deg, #09acf4 0%, #7dd3fc 100%);
            color: white;
            border: none;
            padding: 0.7rem 1.8rem;
            border-radius: 0.6rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(56, 189, 248, 0.2);
        }

        @media (max-width: 768px) {
            .announcement-container {
                padding: 1rem 0.25rem;
            }
            
            .timeline-item {
                padding: 1rem 0;
                gap: 0.8rem;
            }

            .timeline-marker {
                flex: 0 0 25px;
            }

            .timeline-dot {
                width: 12px;
                height: 12px;
                left: 2px;
            }

            .timeline-line {
                left: 5.5px;
                top: 18px;
                bottom: -1rem;
            }

            .announcement-card {
                padding: 1rem;
                margin-top: 0.25rem;
            }

            .announcement-title {
                font-size: 1.05rem;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background: #f1f5f9">
    <?php
    $query = "SELECT name FROM qingka_wangke_user WHERE uid = 1";
    $result = $DB->query($query);
    $nickname = "";
    if ($row = $DB->fetch($result)) {
        $nickname = $row['name'];
    }
    ?>
    <div id="gg" style="max-width: 100vw; overflow-x: hidden">
        <div class="announcement-container">
            <div class="timeline-wrapper">
                <h2 class="text-xl font-bold text-slate-800 mb-6 px-2">最新公告</h2>
                <ul class="modern-timeline">
                    <li v-for="(res, index) in row.data" :key="res.id" class="timeline-item">
                        <div class="timeline-marker">
                            <div class="timeline-dot"></div>
                            <div v-if="index !== row.data.length - 1" class="timeline-line"></div>
                        </div>
                        <div class="flex-1">
                            <div class="time-text">
                                <i class="far fa-calendar-alt text-xs"></i>
                                {{formatDate(res.time)}}
                            </div>
                            <div class="announcement-card">
                                <h3 class="announcement-title">{{res.title}}</h3>
                                <div class="announcement-content" v-html="res.content"></div>
                                <div class="flex gap-2 mt-2">
                                    <div class="tag zhiding-tag" v-if="res.zhiding == 1">
                                        <i class="fas fa-thumbtack mr-1"></i>
                                        置顶
                                    </div>
                                    <div class="tag admin-tag" v-if="res.uid == 1">
                                        <i class="fas fa-user-shield mr-1"></i>
                                        <?php echo htmlspecialchars($nickname); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                
                <div class="text-center mt-6" v-if="hasMore">
                    <button @click="loadMore" class="load-more-btn">
                        加载更多
                        <i class="fas fa-arrow-down ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.27.2/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.layui.com/layui/v2.8.11/layui.min.js"></script>

    <script>
    new Vue({
        el: "#gg",
        data: {
            row: { data: [] },
            page: 1,
            pageSize: 10,
            hasMore: true,
            total: 0
        },
        methods: {
            loadAnnouncements() {
                console.log('当前请求的页码:', this.page);
                axios.post('/apisub.php?act=gglist', {
                    page: this.page,
                    pageSize: this.pageSize
                }).then(response => {
                    const data = response.data;
                    if (data.code === 1) {
                        this.row.data = [...this.row.data, ...data.data];
                        this.hasMore = data.hasMore;
                        this.total = data.total;
                        this.page++;
                        console.log('更新后的页码:', this.page);
                    } else {
                        Swal.fire('提示', data.msg, 'warning');
                    }
                }).catch(error => {
                    Swal.fire('错误', '加载公告失败', 'error');
                });
            },
            loadMore() {
                this.loadAnnouncements();
            },
            formatDate(dateString) {
                const date = new Date(dateString);
                return `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`;
            }
        },
        mounted() {
            this.loadAnnouncements();
        }
    });
    </script>
</body>
</html>
