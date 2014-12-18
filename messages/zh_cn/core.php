<?php
/**
 * Message translations.
 *
 * This file is automatically generated by 'yiic message' command.
 * It contains the localizable messages extracted from source code.
 * You may modify this file by translating the extracted messages.
 *
 * Each array element represents the translation (value) of a message (key).
 * If the value is empty, the message is considered as not translated.
 *
 * NOTE, this file must be saved in UTF-8 encoding.
 *
 * @version $Id: $
 */
return array (
  ':name assigned.' => ':name 已指派',
  ':name created.' => ':name 已创建',
  ':name deleted.' => ':name 已删除',
  ':name module' => ':name 模块',
  ':name revoked.' => ':name 已撤销',
  ':name updated.' => ':name 已更新',
  'A descriptive name for this item.' => '对这个授权项的描述',
  'Add' => '添加',
  'Add Child' => '添加子项',
  'Additional data available when executing the business rule.' => '执行这个业务逻辑所需的数据',
  'An item with this name already exists.' => '已存在一个同名的授权项',
  'Application' => '应用程序',
  'Are you sure you want to delete this item?' => '您确定要删除该授权项吗？',
  'Are you sure you want to delete this operation?' => '您确定要删除该操作吗？',
  'Are you sure you want to delete this role?' => '您确定要删除该角色吗？',
  'Are you sure you want to delete this task?' => '您确定要删除该任务吗？',
  'Assign' => '指派',
  'Assign item' => '指派授权项',
  'Assigned items' => '已指派的授权项',
  'Assignments' => '授权',
  'Assignments for :username' => '对 :username 的授权',
  'Authorization item' => '',
  'Authorization items created.' => '',
  'Business rule' => '业务规则',
  'Business rule cannot be empty.' => '业务规则不能为空',
  'Child :name added.' => '子项 :name 已添加',
  'Child :name removed.' => '子项 :name 已删除',
  'Children' => '子项',
  'Code that will be executed when performing access checking.' => '访问检查时这些代码将被执行',
  'Create :type' => '创建 :type',
  'Create a new operation' => '创建一个新操作',
  'Create a new role' => '创建一个新角色',
  'Create a new task' => '创建一个新任务',
  'Data' => '数据',
  'Delete' => '删除',
  'Description' => '描述',
  'Do not change the name unless you know what you are doing.' => '不要修改这个名字，除非你知道你在做什么。',
  'Generate' => '生成',
  'Generator' => '生成器',
  'Hover to see from where the permission is inherited.' => '悬停以查看从何处继承该权限。',
  'Inherited' => '继承的',
  'Invalid authorization item type.' => '无效的授权项类型。',
  'Invalid request. Please do not repeat this request again.' => '无效请求，请不要重复这次请求。',
  'Item' => '项目',
  'Modules' => '模块',
  'Name' => '名称',
  'Name of the superuser cannot be changed.' => '超级用户的名字不能修改。',
  'No actions found.' => '没有找到任何动作。',
  'No assignments available to be assigned to this user.' => '没有可用的指派可以授权给这个用户。',
  'No authorization items found.' => '没有找到授权项。',
  'No children available to be added to this item.' => '对这个项目没有可添加的子项。',
  'No operations found.' => '没有找到任何操作。',
  'No relations need to be set for the superuser role.' => '无需为超级用户设置关系。',
  'No roles found.' => '没有找到任何角色。',
  'No tasks found.' => '没有找到任何任务。',
  'No users found.' => '没有找到任何用户。',
  'Operation' => '操作',
  'Operations' => '操作',
  'Parents' => '父项',
  'Permissions' => '权限',
  'Please select which items you wish to generate.' => '请选择您要生成的项目。',
  'Relations' => '关系',
  'Remove' => '删除',
  'Revoke' => '撤销',
  'Role' => '角色',
  'Roles' => '角色',
  'Save' => '保存',
  'Select all' => '全选',
  'Select none' => '不选',
  'Super users are always granted access implicitly.' => '超级用户总是被授予完全许可。',
  'Task' => '任务',
  'Tasks' => '任务',
  'The requested page does not exist.' => '请求的页面不存在。',
  'This item has no children.' => '这个项目没有子项。',
  'This item has no parents.' => '这个项目没有父项。',
  'This user has not been assigned any items.' => '这个用户没有被指派任何授权项。',
  'Type' => '类型',
  'Update :name (:type)' => '更新 :name (:type)',
  'Values within square brackets tell how many children each item has.' => '括号里的数字表示这个项目有多少个子项。',
  'You are not authorized to perform this action.' => '您没有被授权执行该操作。',
  'Here you can view which permissions has been assigned to each user.' =>'为用户分配角色。',
  'Here you can view and manage the permissions assigned to each role.'=>'为角色分配授权项目。',
  'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.'=>'权限项目由 {roleLink}, {taskLink} 和 {operationLink} 组成。',
  'Generate items for controller actions'=>'为 controller actions 生成授权项目',
  'Generate items'=>'生成授权项目',
  'A role is group of permissions to perform a variety of tasks and operations, for example the authenticated user.'=>'角色是由任务和操作组成的权限集合，比如已登录的用户。',
  'Roles exist at the top of the authorization hierarchy and can therefore inherit from other roles, tasks and/or operations.'=>'角色处于授权层级的顶层，因此可以继承其他角色，任务或者操作，来实现权限的继承。',
  'Cancel'=>'取消',
  'A task is a permission to perform multiple operations, for example accessing a group of controller action.'=>'任务是由操作组成的权限集合，比如访问一个 controller 下的一组 action 。',
  'Tasks exist below roles in the authorization hierarchy and can therefore only inherit from other tasks and/or operations.'=>'任务在权限层级中处于角色的下一级，因此只可以继承其他任务或操作。',
  'An operation is a permission to perform a single operation, for example accessing a certain controller action.'=>'操作是原子权限，比如访问一个特定的 action 。',
  'Operations exist below tasks in the authorization hierarchy and can therefore only inherit from other operations.'=>'操作处于权限层级中的底层，因此只能继承其他操作。',
);
