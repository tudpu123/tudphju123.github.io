<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>微信城市群聊会员系统</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>微信城市群聊会员</h1>
            <p>加入我们的会员，获取本地最新资讯和优质资源</p>
        </div>
        
        <div class="content">
            <h2>选择城市</h2>
            <p>请选择您想要加入的城市群聊：</p>
            
            <div class="city-selector" id="citySelector">
                <div class="city-item" data-city="全国">全国群</div>
                <div class="city-item" data-city="北京">北京群</div>
                <div class="city-item" data-city="上海">上海群</div>
                <div class="city-item" data-city="广州">广州群</div>
                <div class="city-item" data-city="深圳">深圳群</div>
                <div class="city-item" data-city="杭州">杭州群</div>
                <div class="city-item" data-city="成都">成都群</div>
                <div class="city-item" data-city="武汉">武汉群</div>
                <div class="city-item" data-city="西安">西安群</div>
                <div class="city-item" data-city="南京">南京群</div>
                <div class="city-item" data-city="重庆">重庆群</div>
                <div class="city-item" data-city="天津">天津群</div>
            </div>
            
            <h2 style="margin-top: 60px;">选择套餐</h2>
            <p>请选择适合您的会员套餐：</p>
            
            <div class="product-cards">
                <div class="product-card">
                    <h3>基础会员</h3>
                    <div class="price">¥99<span small>/月</span></div>
                    <ul class="features">
                        <li>加入1个城市群聊</li>
                        <li>获取日常资讯推送</li>
                        <li>参与群内基础活动</li>
                        <li>基础资源共享</li>
                    </ul>
                    <a href="javascript:void(0);" class="btn select-plan" data-amount="99.00">立即开通</a>
                </div>
                
                <div class="product-card">
                    <h3>高级会员</h3>
                    <div class="price">¥199<span small>/月</span></div>
                    <ul class="features">
                        <li>加入3个城市群聊</li>
                        <li>优先获取最新资讯</li>
                        <li>参与所有群内活动</li>
                        <li>完整资源共享</li>
                        <li>专属客服支持</li>
                    </ul>
                    <a href="javascript:void(0);" class="btn select-plan" data-amount="199.00">立即开通</a>
                </div>
                
                <div class="product-card">
                    <h3>尊享会员</h3>
                    <div class="price">¥299<span small>/月</span></div>
                    <ul class="features">
                        <li>加入所有城市群聊</li>
                        <li>24小时专属顾问</li>
                        <li>优先参与线下活动</li>
                        <li>独家资源访问权</li>
                        <li>一对一商务对接</li>
                        <li>定制化服务</li>
                    </ul>
                    <a href="javascript:void(0);" class="btn select-plan" data-amount="299.00">立即开通</a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; 2024 微信城市群聊会员系统. All rights reserved.</p>
        </div>
    </div>
    
    <script>
        // 城市选择功能
        const cityItems = document.querySelectorAll('.city-item');
        let selectedCity = '全国';
        
        cityItems.forEach(item => {
            item.addEventListener('click', function() {
                // 移除所有选中状态
                cityItems.forEach(el => el.classList.remove('selected'));
                // 添加当前选中状态
                this.classList.add('selected');
                // 保存选中的城市
                selectedCity = this.getAttribute('data-city');
            });
        });
        
        // 默认选中全国
        document.querySelector('.city-item[data-city="全国"]').classList.add('selected');
        
        // 套餐选择功能
        const planButtons = document.querySelectorAll('.select-plan');
        
        planButtons.forEach(button => {
            button.addEventListener('click', function() {
                const amount = this.getAttribute('data-amount');
                // 跳转到支付页面
                window.location.href = `pay.php?city=${encodeURIComponent(selectedCity)}&amount=${amount}`;
            });
        });
    </script>
</body>
</html>