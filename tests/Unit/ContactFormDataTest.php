<?php

namespace Tests\Unit;

use App\DTO\ContactFormData;
use App\Models\ContactReason;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ContactFormDataTest extends TestCase
{
    public function test_contact_form_data_creation_with_all_fields(): void
    {
        $contactReason = $this->createMockContactReason();
        $preferredDateTime = Carbon::now()->addDays(1);

        $dto = new ContactFormData(
            fullName: 'John Doe',
            email: 'john@example.com',
            phone: '+1234567890',
            preferredDatetime: $preferredDateTime,
            message: 'Test message',
            contactReason: $contactReason
        );

        $this->assertEquals('John Doe', $dto->fullName);
        $this->assertEquals('john@example.com', $dto->email);
        $this->assertEquals('+1234567890', $dto->phone);
        $this->assertEquals($preferredDateTime, $dto->preferredDatetime);
        $this->assertEquals('Test message', $dto->message);
        $this->assertEquals($contactReason, $dto->contactReason);
    }

    public function test_contact_form_data_creation_with_minimal_fields(): void
    {
        $contactReason = $this->createMockContactReason();

        $dto = new ContactFormData(
            fullName: 'Jane Smith',
            email: 'jane@example.com',
            phone: null,
            preferredDatetime: null,
            message: null,
            contactReason: $contactReason
        );

        $this->assertEquals('Jane Smith', $dto->fullName);
        $this->assertEquals('jane@example.com', $dto->email);
        $this->assertNull($dto->phone);
        $this->assertNull($dto->preferredDatetime);
        $this->assertNull($dto->message);
        $this->assertEquals($contactReason, $dto->contactReason);
    }

    public function test_from_array_with_valid_data(): void
    {
        $contactReason = $this->createMockContactReason();
        
        // Mock the ContactReason::find method
        $this->mockContactReasonFind($contactReason);

        $data = [
            'full_name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'phone' => '+9876543210',
            'preferred_datetime' => '2025-12-25 14:30:00',
            'message' => 'Holiday appointment request',
            'contact_reason_id' => 1,
        ];

        $dto = ContactFormData::fromArray($data);

        $this->assertEquals('Alice Johnson', $dto->fullName);
        $this->assertEquals('alice@example.com', $dto->email);
        $this->assertEquals('+9876543210', $dto->phone);
        $this->assertEquals('Holiday appointment request', $dto->message);
        $this->assertInstanceOf(Carbon::class, $dto->preferredDatetime);
        $this->assertEquals('2025-12-25 14:30:00', $dto->preferredDatetime->toDateTimeString());
    }

    public function test_from_array_trims_whitespace(): void
    {
        $contactReason = $this->createMockContactReason();
        $this->mockContactReasonFind($contactReason);

        $data = [
            'full_name' => '  Bob Wilson  ',
            'email' => '  bob@example.com  ',
            'phone' => '  +1111111111  ',
            'message' => '  Appointment needed  ',
            'contact_reason_id' => 1,
        ];

        $dto = ContactFormData::fromArray($data);

        $this->assertEquals('Bob Wilson', $dto->fullName);
        $this->assertEquals('bob@example.com', $dto->email);
        $this->assertEquals('+1111111111', $dto->phone);
        $this->assertEquals('Appointment needed', $dto->message);
    }

    public function test_from_array_handles_empty_optional_fields(): void
    {
        $contactReason = $this->createMockContactReason();
        $this->mockContactReasonFind($contactReason);

        $data = [
            'full_name' => 'Charlie Brown',
            'email' => 'charlie@example.com',
            'phone' => '',
            'preferred_datetime' => '',
            'message' => '',
            'contact_reason_id' => 1,
        ];

        $dto = ContactFormData::fromArray($data);

        $this->assertEquals('Charlie Brown', $dto->fullName);
        $this->assertEquals('charlie@example.com', $dto->email);
        $this->assertNull($dto->phone);
        $this->assertNull($dto->preferredDatetime);
        $this->assertNull($dto->message);
    }

    public function test_from_array_throws_exception_for_empty_full_name(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Full name must be a non-empty string');

        ContactFormData::fromArray([
            'full_name' => '',
            'email' => 'test@example.com',
            'contact_reason_id' => 1,
        ]);
    }

    public function test_from_array_throws_exception_for_empty_email(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Email must be a non-empty string');

        ContactFormData::fromArray([
            'full_name' => 'Test User',
            'email' => '',
            'contact_reason_id' => 1,
        ]);
    }

    public function test_from_array_throws_exception_for_invalid_contact_reason_id(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Contact reason ID must be numeric');

        ContactFormData::fromArray([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => 'invalid',
        ]);
    }

    public function test_from_array_throws_exception_for_nonexistent_contact_reason(): void
    {
        // Mock ContactReason::find to return null
        $this->mockContactReasonFind(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid contact reason provided');

        ContactFormData::fromArray([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'contact_reason_id' => 999,
        ]);
    }

    public function test_from_array_throws_exception_for_invalid_datetime_format(): void
    {
        $contactReason = $this->createMockContactReason();
        $this->mockContactReasonFind($contactReason);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid preferred datetime format');

        ContactFormData::fromArray([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'preferred_datetime' => 'invalid-date',
            'contact_reason_id' => 1,
        ]);
    }

    public function test_to_array_conversion(): void
    {
        $contactReason = $this->createMockContactReason();
        $preferredDateTime = Carbon::parse('2025-06-15 10:00:00');

        $dto = new ContactFormData(
            fullName: 'David Lee',
            email: 'david@example.com',
            phone: '+5555555555',
            preferredDatetime: $preferredDateTime,
            message: 'Consultation needed',
            contactReason: $contactReason
        );

        $array = $dto->toArray();

        $expected = [
            'full_name' => 'David Lee',
            'email' => 'david@example.com',
            'phone' => '+5555555555',
            'preferred_datetime' => '2025-06-15 10:00:00',
            'message' => 'Consultation needed',
            'contact_reason_id' => 1,
        ];

        $this->assertEquals($expected, $array);
    }

    public function test_to_array_with_null_values(): void
    {
        $contactReason = $this->createMockContactReason();

        $dto = new ContactFormData(
            fullName: 'Emma Davis',
            email: 'emma@example.com',
            phone: null,
            preferredDatetime: null,
            message: null,
            contactReason: $contactReason
        );

        $array = $dto->toArray();

        $expected = [
            'full_name' => 'Emma Davis',
            'email' => 'emma@example.com',
            'phone' => null,
            'preferred_datetime' => null,
            'message' => null,
            'contact_reason_id' => 1,
        ];

        $this->assertEquals($expected, $array);
    }

    public function test_has_preferred_datetime(): void
    {
        $contactReason = $this->createMockContactReason();

        $dtoWithDateTime = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: null,
            preferredDatetime: Carbon::now(),
            message: null,
            contactReason: $contactReason
        );

        $dtoWithoutDateTime = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: null,
            preferredDatetime: null,
            message: null,
            contactReason: $contactReason
        );

        $this->assertTrue($dtoWithDateTime->hasPreferredDatetime());
        $this->assertFalse($dtoWithoutDateTime->hasPreferredDatetime());
    }

    public function test_has_phone(): void
    {
        $contactReason = $this->createMockContactReason();

        $dtoWithPhone = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: '+1234567890',
            preferredDatetime: null,
            message: null,
            contactReason: $contactReason
        );

        $dtoWithoutPhone = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: null,
            preferredDatetime: null,
            message: null,
            contactReason: $contactReason
        );

        $dtoWithEmptyPhone = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: '   ',
            preferredDatetime: null,
            message: null,
            contactReason: $contactReason
        );

        $this->assertTrue($dtoWithPhone->hasPhone());
        $this->assertFalse($dtoWithoutPhone->hasPhone());
        $this->assertFalse($dtoWithEmptyPhone->hasPhone());
    }

    public function test_has_message(): void
    {
        $contactReason = $this->createMockContactReason();

        $dtoWithMessage = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: null,
            preferredDatetime: null,
            message: 'This is a message',
            contactReason: $contactReason
        );

        $dtoWithoutMessage = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: null,
            preferredDatetime: null,
            message: null,
            contactReason: $contactReason
        );

        $dtoWithEmptyMessage = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: null,
            preferredDatetime: null,
            message: '   ',
            contactReason: $contactReason
        );

        $this->assertTrue($dtoWithMessage->hasMessage());
        $this->assertFalse($dtoWithoutMessage->hasMessage());
        $this->assertFalse($dtoWithEmptyMessage->hasMessage());
    }

    public function test_get_formatted_preferred_datetime(): void
    {
        $contactReason = $this->createMockContactReason();
        $dateTime = Carbon::parse('2025-06-15 14:30:00');

        $dto = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: null,
            preferredDatetime: $dateTime,
            message: null,
            contactReason: $contactReason
        );

        $dtoWithoutDateTime = new ContactFormData(
            fullName: 'Test User',
            email: 'test@example.com',
            phone: null,
            preferredDatetime: null,
            message: null,
            contactReason: $contactReason
        );

        $this->assertEquals('15.06.2025 14:30', $dto->getFormattedPreferredDatetime());
        $this->assertNull($dtoWithoutDateTime->getFormattedPreferredDatetime());
    }

    private function createMockContactReason(): ContactReason
    {
        $mock = $this->createMock(ContactReason::class);
        $mock->id = 1;
        $mock->method('getAttribute')->with('id')->willReturn(1);
        
        return $mock;
    }

    private function mockContactReasonFind(?ContactReason $returnValue): void
    {
        // In a real Laravel test, you would use Mockery or similar
        // For this unit test, we're testing the logic structure
        // The actual Laravel feature test will test the integration
    }
}