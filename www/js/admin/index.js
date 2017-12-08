  //公共变量
  var token = $.cookie('token'),
      httpStr = 'http://www.mxooc.site/admin/';


$(function(){
  ///vue
  //注销
  var logut = new Vue({
    el: '#logut',
    data: {  },
    methods: {
      logut: function () {
            window.location.href = httpStr+'login/index';
      }
    }
  })

  //获取图片分组列表
  var getImgGroup = new Vue({
      el: '#allImgGroup',
      data: {
          getImgGroupUrl: httpStr+'group/getList?token=' + token,
          getListByGroupIdUrl: httpStr+'image/getListByGroupId?token=' + token,
          groups:[
            {name:'',
            id:''
            },
          ],
          imgs:[
            {
              src:'',
              name:''
            }
          ]
      },
      created: function() {
          this.getImgGrouo();
      },
      methods: {
          //获取分组列表
          getImgGrouo: function() {
              var that = this;
              that.$http({
                  method: 'GET',
                  url: this.getImgGroupUrl
              }).then(function(response) {
                  this.groups=response.body.groups;
              }, function(error) {
              });
          },

          //根据分组ID获取图片列表
          selectGroup: function(dom) {
            var that = this;
            var id = dom.target.value;
            that.$http({
                method: 'GET',
                url: this.getListByGroupIdUrl+'&group_id='+id
            }).then(function(response) {
                console.log(response);
                this.groups=response.body.groups;
            }, function(error) {
            });
        }
      
    
      }
  });


  ///jquery

//左侧li切换
 $('.tabNav').on('click','li',function(){
   var Id = $(this).attr('name');
   $('#'+Id).removeClass('displayNone').siblings().addClass('displayNone');
 })
 
  //图片分页
  $('#imgListPage').initPage(20,1,function(a){

  })
 

  //图片上传input
  $('#uploadInput').change(function(){
    var obj =this;   
     var length = obj.files.length;   
     var allName = '';
      for(var i=0;i<obj.files.length;i++){      
          allName += '<li>'+obj.files[i].name+'</li>';         
       }
    $('#fileNames').html(allName)
    
   
  })
})
 
  