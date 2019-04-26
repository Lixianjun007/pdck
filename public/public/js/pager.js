/**
 * @description 分页控件
 * @param el {String|Object} 分页容器，当只传入此参数时应为Object类型
 * @param options {Object} 配置信息
 * @author fanlinjun
 * options示例： options: { [el: '.pagebar',] idx: 1, pageSize: 10, total: 278, skipCall: <function> }
 * */ 
function pager(el, options){
    var _options = options || el;
    var _el = _options.el || el;
    _options.idx = _options.idx || 1;
    if(!_el){
        console.error('The argument "el" or the property "el" of "options" is unusable!');
        return; 
    }
    if(!/^[\.\#][\w\-]+$/.test(_el)){
        console.error('The argument "el" or the property "el" of "options" should be class selector or id selector');
        return;
    }
    _options.total = _options.total || 0;
    //默认每页十条数据
    _options.pageSize = _options.pageSize || 10;
    //总页数
    var _pageCount = Math.ceil(_options.total / _options.pageSize);
    
    /**
     * @description 渲染分页控件
     * @param idx {Number} 当前页码
     * @returns {void}
     * */ 
    function renderBar(idx){
        var _html = '', _cls = '', _box;
        if(/^\#.+$/.test(_el)){
            _box = document.getElementById(_el.substr(1));
        }else{
            _box = document.getElementsByClassName(_el.substr(1))[0];
        }

        idx = idx || 1;
        if(!_box){
            console.error('The element selected by selector "' + _el + '" is unusable');
            return;
        }
        if(_pageCount == 1){
            return;
        }
        for(var i = 1; i < _pageCount + 1; i++){
            if(i == 1 || i == _pageCount || Math.abs(idx - i) < 2){
                _cls = i == idx ? 'pageidx on' : 'pageidx';
                _html += '<a class="' + _cls + '">' + i + '</a>';
            }else{
                _html += '<a class="elips">...</a>';
                i += i < idx ? idx - 4 : _pageCount - idx - 3;
            }
        }
        
        _html = '<span class="link_box"><a class="pre_page"></a>' + _html + '<a class="next_page"></a></span>';
        _html = '<span class="summary">共<i class="totle_page">' + _pageCount + '</i>页</span>' + _html;
        _html += '<span class="skip_box"><label>到第<input type="text" class="skip_to">页</label><a class="btn_skip">跳转</a></span></p>';
        _box.innerHTML = '<p class="pager">' + _html + '</p>';
        bindEvents();
    }

    /**
     * @description 获取输入框内容
     * @param ele {Element} input标签元素
     * @returns {Number}
     * */ 
    function getInputVal(ele){
        var _input = ele || document.getElementsByClassName('skip_to')[0];
        var _val = 0;
        if(!_input){ return 0; }
        _val = parseInt(_input.value.trim());
        if(isNaN(_val)){
            console.warn('The target page index to skip to you inputted should be a number and range from 1 to ' + _pageCount);
            return 0;
        }
        if(_val < 1 || _val > _pageCount){
            console.warn('The target page index to skip to you inputted should range from 1 to ' + _pageCount);
            return 0;
        }
        return _val;
    }
    
    /**
     * @description 为按钮绑定事件
     * @returns {void}
     * */ 
    function bindEvents(){
        var _btn_idxs = document.getElementsByClassName('pageidx'), $this = this;
        var _btnmap = { 'pre_page': -1, 'next_page': 1 }, _btn;
        //绑定页码按钮单击事件
        for(var i = 0; i < _btn_idxs.length; i++){
            _btn_idxs[i].onclick = function(e){
                _options.idx = parseInt(this.innerText);
                skipTo(_options.idx);
            }
        }
        //绑定上一页/下一页按钮单击事件
        for(var v in _btnmap){
            _btn = document.getElementsByClassName(v)[0];
            if(!_btn){ continue; }
            _btn.onclick = function(){
                _options.idx += _btnmap[this.className];
                if(_options.idx < 1 || _options.idx > _pageCount){ 
                    _options.idx -= _btnmap[this.className];
                    return; 
                }
                skipTo(_options.idx);
            }
        }
        //绑定跳转按钮单击事件
        _btn = document.getElementsByClassName('btn_skip')[0];
        if(!!_btn){
            _btn.onclick = function(){
                __val = getInputVal();
                if(__val == 0){ return; }
                skipTo(__val);
            }
        }
        //绑定输入框的回车事件
        _btn = document.getElementsByClassName('skip_to')[0];
        if(!!_btn){
            _btn.onkeydown = function(e){
                e = e || window.event;
                if(e.keyCode == 13){
                    __val = getInputVal(this);
                    if(__val == 0){ return; }
                    skipTo(__val);
                }
            }
        }
    }

    /**
     * @description 跳到指定页
     * @param idx {Number} 指定页码
     * @returns {void}
     * */ 
    function skipTo(idx){
        if(_options.skipCall && typeof(_options.skipCall) == 'function'){
            _options.skipCall(idx, _options.pageSize);
            renderBar(idx);
        }else{
            console.warn('The property "skipCall" of "el"(when there is none of argument "options") or "options" should be a function, but now is not');
        }
    }

    //初始化
    this.init = function(){
        renderBar(_options.idx);
        return this;
    }

    /**
     * @description 更新设置信息，并重新渲染控件（当总记录数或每页记录条数发生变化时调用）
     * @param option {Object} 设置选项
     * @returns {void}
     * option示例：{
     *      total: <Number>,        //更新后的总记录条数(可选)
     *      pageSize: <Number>      //更新后的单页记录条数(可选)
     * }
     * */ 
    this.update = function(option){
        var _rate = 1;
        if(option.total && typeof(option.total) == 'number'){
            _options.total = option.total;
        }
        if(option.pageSize && typeof(option.pageSize) == 'number'){
            _rate = _options.pageSize / option.pageSize;
            _options.pageSize = option.pageSize;
        }
        _pageCount = Math.ceil(_options.total / _options.pageSize);
        _options.idx = Math.floor(_options.idx * _rate);
        renderBar(_options.idx);
    }
}
