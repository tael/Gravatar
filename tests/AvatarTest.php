<?php
use Gravatar\Avatar;

// TODO: 실제 등록된 이메일 이라면 그라바타에서 이미지를 주고, 아니라면 d=404 옵션을 통해서 존재하지 않음을 확인할 수 있다.
class AvatarTest extends PHPUnit_Framework_TestCase
{
    public function test_getUrl()
    {
        self::assertEquals("", Avatar::create()->getUrl());
        self::assertEquals("http://www.gravatar.com/avatar/8b3235c64c1fa8d09a03767dd69c0392"
            , Avatar::create()->setEmail("tikim@yellocorp.com")->getUrl());
        self::assertEquals("http://www.gravatar.com/avatar/690cfb93f7b4ff39ce12362ff29b10c9"
            , Avatar::create()->setEmail("tikim@yellostory.co.kr")->getUrl());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_malformed_email()
    {
        Avatar::create()->setEmail("malformed@..")->getUrl();
    }

    public function test_addParams()
    {
        $pairs = ["d" => 404, "a" => "b"];
        self::assertEquals(
            "http://www.gravatar.com/avatar/690cfb93f7b4ff39ce12362ff29b10c9?d=404&a=b",
            Avatar::create()
                ->setEmail("tikim@yellostory.co.kr")
                ->addParams($pairs)
                ->getUrl()
        );
    }

    public function test_addParam()
    {
        self::assertEquals(
            "http://www.gravatar.com/avatar/690cfb93f7b4ff39ce12362ff29b10c9?d=404&a=b",
            Avatar::create()
                ->setEmail("tikim@yellostory.co.kr")
                ->addParam("d", 404)
                ->addParam("a", "b")
                ->getUrl()
        );
    }

}
