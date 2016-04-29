# 目录说明
此目录下的类, 为MySQL数据库的映射, 一个表对应一个类.

# 命名说明

## 子文件说明
+ `Base`: ORM的基类.
+ `Mapper`: 为 Model 提供 **操作** 功能(例如:加载,保存, 缓存等), 与 Model 一一对应.

## 模块名, 库名, 表名与Model的对应关系
为什么会有这样的规则?
主要解决三个问题:
+ 模块名与库名有业务上的对应关系.
+ 防止不同库中有相同表名的冲突.
+ 类名不要太长长长长.

嗯, 为了解析用例子来说明规则:

### 普通情况
命名规则: \Orm\'模块名'\'表名'

模块名:`core`, 库名:`hlghlgcore`, 表名:`task_flag`

对应的Model名称: `\Orm\Core\Task\FlagModel`

### 前缀重复
命名规则: \Orm\'模块名'\'表名(去前缀)'

模块名:`core`, 库名:`hlghlgcore`, 表名:`core_shop_trade`

对应的Model名称: `\Orm\Core\Shop\TradeModel`
