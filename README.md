# HHVMCraft

STATUS: MIGRATING TO REGULAR VANILLA PHP
* Can't compile HHVM on my Yosemite machine anymore, sadly ): *

[![Build Status](https://travis-ci.org/andrewvy/HHVMCraft.svg?branch=master)](https://travis-ci.org/andrewvy/HHVMCraft)

A Minecraft Beta 1.7.3 Server implemented in PHP, based off of 
[Truecraft's implementation](https://github.com/SirCmpwn/TrueCraft).

The goal of this project is not to be a fully-functional server,
but rather a proof-of-concept for PHP and HHVM.

### Installation?

You need pear + pecl + composer.

Also, [libevent is required.](http://libevent.org/) along with [event](https://pecl.php.net/package/event)

### Why?

This is a little coding exercise/project, it's not intended to be a serious 
application. :)

As you can tell, this is not the most performant implementation. It's being
developed in a way that's fast to code, and readable.

I am also not a PHP programmer, nor do I know much about socket programming! ;)

So if you have any comments, please feel free to create an issue.

## Current Progress

------- 60% -------

- EntityManager needs to be fleshed out.
- BlockRepository and BlockProviders need to be added.
- ItemRepository and ItemProviders need to be added.
- CraftingRepository and CraftingProvider need to be added.
- PhysicsEngine needs to be added.
- Bunch'o packets need to be created.
- Chunk data needs to be sent over.
- NBT deserializing/serializing needs to be added.
- Packet Handlers need to be added.

We can actually walk around on stuff and chat!

![](https://cloud.githubusercontent.com/assets/2051361/9459210/b9a2cfb8-4aad-11e5-9164-66e1da98808a.png)

## Libraries used

[Evenement](https://github.com/igorw/evenement) - Event Dispatching Library  
[ReactPHP](https://github.com/reactphp/react) - Low-level async event-driven library for PHP.  
[PHP-NBT-Decoder-Encoder](https://github.com/TheFrozenFire/PHP-NBT-Decoder-Encoder) - NBT Serializer/Deserializer  
[PHPUnit](https://phpunit.de) - PHP Testing Framework  
[Monolog](https://github.com/Seldaek/monolog) - Logging Framework  
